<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\QueryType;
use ApiBundle\Model\Query;
use VulgarDetectorBundle\Detector\SimilarDetector;
use VulgarDetectorBundle\Normalizer\LowercaseNormalizer;
use VulgarDetectorBundle\Repository\WordRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VulgarDetectorBundle\Service\RequestService;
use VulgarDetectorBundle\Tokenizer\WordTokenizer;

class VulgarDetectorController extends BaseController
{
    /**
     * @return Response
     */
    public function statusAction()
    {
        /** @var WordRepository $wordRepository */
        $wordRepository = $this->get('vulgar_detector.word.repository');

        $data = [
            'words' => $wordRepository->getWordsCount(),
            'languages' => $wordRepository->getLanguagesCount()
        ];

        return JsonResponse::create($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function checkAction(Request $request)
    {
        /** @var RequestService $requestService */
        $requestService = $this->get('vulgar_detector.service.request_service');
        $count = $requestService->getRequestByIp($request->getClientIp());
        $requestLimit = $this->getParameter('request_limit');

        if ($count > $requestLimit) {
            return JsonResponse::create([
                'STATUS' => 'Limit'
            ], Response::HTTP_BAD_REQUEST);
        }

        $form = $this->createForm(QueryType::class);
        $submittedData = json_decode($request->getContent(), true);
        $form->submit($submittedData);

        if (!$form->isValid()) {
            return $this->error($this->getFormErrorsAsArray($form));
        }

        /** @var Query $query */
        $query = $form->getData();
        $requestService->logRequest($request->getClientIp(), $query->text);

        /** @var WordTokenizer $wordTokenizer */
        $wordTokenizer = $this->get('vulgar_detector.word_tokenizer');
        $arrayWords = $wordTokenizer->tokenize($query->text);

        /** @var LowercaseNormalizer $lowercaseNormalizer */
        $lowercaseNormalizer  = $this->get('vulgar_detector.lowercase_normalizer');
        $arrayWords = $lowercaseNormalizer->normalize($arrayWords);

        /** @var SimilarDetector $similarDetector */
        $similarDetector= $this->get('vulgar_detector.detector.similar_detector');

        $result = $similarDetector->isVulgar($arrayWords, $query->language);

        return JsonResponse::create([
            'STATUS' => $result ? 'VULGAR' : 'DECENT'
        ], Response::HTTP_OK);
    }
}
