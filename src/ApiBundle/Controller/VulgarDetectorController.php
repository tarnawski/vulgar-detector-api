<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\QueryType;
use ApiBundle\Model\Query;
use VulgarDetectorBundle\Detector\SimilarDetector;
use VulgarDetectorBundle\Normalizer\LowercaseNormalizer;
use VulgarDetectorBundle\Normalizer\NormalizerFactory;
use VulgarDetectorBundle\Repository\RequestRepository;
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
        /** @var RequestRepository $requestRepository */
        $requestRepository = $this->get('vulgar_detector.request.repository');

        $data = [
            'words' => $wordRepository->getWordsCount(),
            'languages' => $wordRepository->getLanguagesCount(),
            'requests' => $requestRepository->getCountRequest(),
            'requests_today' => $requestRepository->getCountRequestToday()
        ];

        return JsonResponse::create($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function checkAction(Request $request)
    {
        /** @var RequestRepository $requestRepository */
        $requestRepository = $this->get('vulgar_detector.request.repository');
        $requestCount = $requestRepository->getCountRequestByIp($request->getClientIp());
        $requestLimit = $this->getParameter('request_limit');

        if ($requestCount > $requestLimit) {
            return JsonResponse::create([
                'STATUS' => sprintf('Limit %s request per day has been exhausted', $requestLimit)
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

        /** @var RequestService $requestService */
        $requestService = $this->get('vulgar_detector.service.request_service');
        $requestService->logRequest($request->getClientIp(), $query->text);

        /** @var WordTokenizer $wordTokenizer */
        $wordTokenizer = $this->get('vulgar_detector.word_tokenizer');
        $arrayWords = $wordTokenizer->tokenize($query->text);

        /** @var NormalizerFactory $normalizer */
        $normalizer = $this->get('vulgar_detector.normalizer_factory');
        $arrayWords = $normalizer->normalize($arrayWords, ['LOWERCASE', 'STOP_WORDS', 'UNIQUE']);

        /** @var SimilarDetector $similarDetector */
        $similarDetector= $this->get('vulgar_detector.detector.similar_detector');

        $result = $similarDetector->isVulgar($arrayWords, $query->language);

        return JsonResponse::create([
            'STATUS' => $result ? 'VULGAR' : 'DECENT'
        ], Response::HTTP_OK);
    }
}
