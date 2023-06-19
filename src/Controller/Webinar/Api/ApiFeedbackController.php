<?php

namespace App\Controller\Webinar\Api;

use App\Entity\Webinar\Feedback;
use App\Repository\Webinar\FeedbackRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Exception;

class ApiFeedbackController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/api/webinar/feedback/create/sample', name: 'api_webinar_feedback_create_sample')]
    public function createSample(Request $request, ManagerRegistry $registry): JsonResponse
    {
        /** @var $requestData | cURL - JSON raw data. Content-Type: application/json */
        $requestData = $request->toArray();

        /** @var FeedbackRepository $feedbackRepo */
        $feedbackRepo = $registry->getRepository(Feedback::class);

        $feedback = $feedbackRepo->findOneBy(['Boundary' => $requestData['boundary']]);

        if (is_null($feedback)) {
            $feedback = new Feedback();

            $feedback->setPageID($requestData['page_id'] ?: throw new Exception('PageID cannot be null or empty'));
            $feedback->setBoundary($requestData['boundary'] ?: throw new Exception('Boundary cannot be null or empty'));
            $feedback->setRoistatID($requestData['roistat_id']);
            $feedback->setVisitorInfo($requestData['visitor_info']);
            $feedback->setFingerprint($requestData['fingerprint']);
            $feedback->setYanUID($requestData['yan_uid']);
            $feedback->setUIP($requestData['uip']);
            $feedback->setCreated(new \DateTime(date("Y-m-d H:i:s")));
            $feedback->setStatus("Active");

            $feedbackRepo->save($feedback, true);

            /** @var string $formSamplePath | Path to form samples */
            $formSamplePath = $this->getParameter('feedback_form');

            if (!is_dir($formSamplePath)) {
                mkdir($formSamplePath);
            }

            file_put_contents($formSamplePath . "/" . $feedback->getBoundary(), base64_decode($requestData['content']));
        }

        return new JsonResponse(['status' => $feedback->getStatus()]);
    }
}
