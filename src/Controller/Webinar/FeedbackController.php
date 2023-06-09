<?php

namespace App\Controller\Webinar;

use App\Entity\Webinar\Feedback;
use App\Form\Webinar\FeedbackType;
use App\Repository\Webinar\FeedbackRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Exception;
use Throwable;

class FeedbackController extends AbstractController
{
    #[Route('/webinar/feedback', name: 'app_webinar_feedback')]
    public function index(): Response
    {
        return $this->render('webinar/feedback/index.html.twig', [
            'controller_name' => 'ApiFeedbackController',
        ]);
    }

    #[Route('/webinar/feedback/form', name: 'app_webinar_feedback_form')]
    public function getFeedbackForm(): Response
    {
        return $this->redirectToRoute('app_webinar_feedback_form_boundary', ['boundary' => "empty"]);
    }

    #[Route('/webinar/feedback/form/{boundary}', name: 'app_webinar_feedback_form_boundary')]
    public function getFeedbackFormByBoundary(string $boundary, Request $request, ManagerRegistry $registry): Response
    {
        /** @var FeedbackRepository $feedbackRepo */
        $feedbackRepo = $registry->getRepository(Feedback::class);

        /** @var Feedback $feedback */
        $feedback = $feedbackRepo->findOneBy(['Boundary' => $boundary]);

        if (!is_null($feedback)) {
            if ($feedback->getStatus() == "Complete") {
                return $this->render('webinar/feedback/completed.html.twig');
            }
        }

        $formSamplesPath = $this->getParameter('feedback_form');

        try {
            $sample = new File($formSamplesPath . "/" . $boundary);
        } catch (Exception | Throwable $e) {
            return $this->render('webinar/feedback/failed.html.twig', [
                'error_message' => $e->getMessage()
            ]);
        }

        $form = $this->createForm(FeedbackType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            /** @var Feedback $task */
            $task = $form->getData();

            if (!is_null($feedback)) {
                file_put_contents($formSamplesPath . "/emails.log", $task['EmailHash'] . "\n", FILE_APPEND);
                $feedback->setEmailHash(md5($task['EmailHash']));

                $requsetData = $request->request->all();
                unset($requsetData['feedback']);

                $feedback->setFormParams(json_encode($requsetData));
                $feedback->setStatus('Complete');
                $feedbackRepo->save($feedback, true);

                unlink($formSamplesPath . "/" . $boundary);

                return $this->render('webinar/feedback/completed.html.twig');
            }
        }

        return $this->render('webinar/feedback/form.html.twig', [
            'sample' => $sample->getContent(),
            'feedback' => $form->createView(),
        ]);
    }
}
