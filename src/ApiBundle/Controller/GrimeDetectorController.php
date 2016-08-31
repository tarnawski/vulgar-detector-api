<?php

namespace ApiBundle\Controller;

use ApiBundle\Form\Type\QueryType;
use ApiBundle\Model\Query;
use VulgarDetectorBundle\Corrector\VulgarCorrector;
use VulgarDetectorBundle\Detector\StrategyFactory;
use VulgarDetectorBundle\Service\StatisticService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VulgarDetectorController extends BaseController
{
    /**
     * @return Response
     */
    public function statusAction()
    {
        /** @var StatisticService $statisticService */
        $statisticService = $this->get('vulgar_detector.service.statistic_service');

        $data = [
            'checked' => $statisticService->getStatistic('TEXT_CHECKED'),
            'training_data' => $statisticService->getStatistic('LEARNING_DATA'),
            'efficiency' => $statisticService->getStatistic('EFFICIENCY')
        ];

        return JsonResponse::create($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function checkAction(Request $request)
    {
        $form = $this->createForm(QueryType::class);
        $submittedData = json_decode($request->getContent(), true);
        $form->submit($submittedData);

        if (!$form->isValid()) {
            return $this->error($this->getFormErrorsAsArray($form));
        }

        /** @var Query $query */
        $query = $form->getData();

        /** @var StrategyFactory $strategyFactory */
        $strategyFactory = $this->get('vulgar_detector.detector.strategy_factory');
        $strategy = $strategyFactory->getStrategy('static');

        $result = $strategy->check($query->text, $query->language);

        if ($result) {
            return JsonResponse::create([
                'STATUS' => 'OK'
            ], Response::HTTP_OK);
        }

        if ($query->correct) {
            /** @var VulgarCorrector $vulgarCorrector */
            $vulgarCorrector = $this->get('vulgar_detector.corrector.vulgar_corrector');
            $correctText = $vulgarCorrector->correct($query->text, $query->language);

            return JsonResponse::create([
                'STATUS' => 'VULGAR',
                'CORRECT' => $correctText
            ], Response::HTTP_OK);
        }

        return JsonResponse::create([
            'STATUS' => 'VULGAR'
        ], Response::HTTP_OK);
    }
}
