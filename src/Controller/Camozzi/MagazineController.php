<?php

namespace App\Controller\Camozzi;

use App\Entity\Camozzi\Magazine;
use App\Form\Camozzi\SearchType;
use App\Repository\Camozzi\MagazineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MagazineController extends AbstractController
{
    #[Route('/camozzi/magazine', name: 'app_camozzi_magazine')]
    public function magazine(ManagerRegistry $registry, Request $request): Response
    {
        $where = $orderBy = $twigOptions = [];
        $limit = 25;
        $offset = 0;

        $search = $this->createForm(SearchType::class);
        $search->handleRequest($request);

        if ($search->isSubmitted() and $search->isValid()) {
            $formData = $search->getData();
            $where = [$formData['attribute'] => $formData['search']];
        }

        if ($sorting = $request->query->get('sorting')) {
            [$attribute, $condition] = explode("=", $sorting,2);
            $orderBy = [$attribute => $condition];
        }

        if ($page = $request->query->get('page')) {
            [$page] = explode("=", $page, 1);
            if ($page < 2) {
                $page = 1;
            } elseif ($page > 1) {
                $offset = $limit * $page - 1;
            }

            $twigOptions += ['page' => $page];
        }

        /** @var MagazineRepository $magazine */
        $magazine = $registry->getRepository(Magazine::class)->findByCriteria(
            where: $where, orderBy: $orderBy, limit: $limit, offset: $offset
        );

        return $this->render('camozzi/magazine/index.html.twig', $twigOptions + [
            'search' => $search->createView(),
            'magazine' => $magazine,
        ]);
    }
}
