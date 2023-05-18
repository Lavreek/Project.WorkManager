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

class FeedbackController extends AbstractController
{
    #[Route('/webinar/feedback', name: 'app_webinar_feedback')]
    public function index(): Response
    {
        return $this->render('webinar/feedback/index.html.twig', [
            'controller_name' => 'ApiFeedbackController',
        ]);
    }

    #[Route('/webinar/feedback/form/{boundary}', name: 'app_webinar_feedback_form')]
    public function getForm(string $boundary, Request $request, ManagerRegistry $registry): Response
    {
        $formSamplesPath = $this->getParameter('feedback_form');
        $sample = new File($formSamplesPath . "/" . $boundary);

        $form = $this->createForm(FeedbackType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $task = $form->getData();
            dd($task);
            /** @var FeedbackRepository $feedbackRepo */
            $feedbackRepo = $registry->getRepository(Feedback::class);

//            $feedback = $feedbackRepo->findOneBy(['Boundary' => $boundary]);

//            $feedback->set
        }

        return $this->render('webinar/feedback/form.html.twig', [
            'sample' => $sample->getContent(),
            'feedback' => $form->createView(),
        ]);
    }
}
