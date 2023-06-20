<?php

namespace App\Controller\Calculator;

use App\Form\Calculator\GasConsumptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GasConsumptionController extends AbstractController
{
    #[Route('/calculator/gas_consumption', name: 'app_calculator_gas_consumption')]
    public function getGasConsumption(Request $request): Response
    {
        $form = $this->createForm(GasConsumptionType::class);
        $form->handleRequest($request);

        $result = "";

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $ro = $data['gc_ro1'] / $data['gc_ro0'];
            $r = $data['gc_r0'] / $data['gc_r1'];
            $t = $data['gc_t1'] / $data['gc_t0'];

            $result = $data['gc_q1'] * sqrt($ro * $r * $t);
        }

        return $this->render('calculator/gas_consumption/index.html.twig', [
            'calculator' => $form->createView(),
            'result' => $result
        ]);
    }
}
