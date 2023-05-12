<?php

namespace App\Controller\Camozzi\Api;

use App\Entity\Camozzi\Magazine;
use App\Repository\Camozzi\MagazineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiMagazineController extends AbstractController
{
    #[Route('/api/camozzi/magazine/flush', name: 'api_camozzi_magazine_flush', methods: ['POST'])]
    public function magazineFlush(Request $request, ManagerRegistry $registry): JsonResponse
    {
        $requestData = $request->request->all();

        if ($attachments = json_decode($requestData['attachments'], true)) {
            /** @var MagazineRepository $magazine */
            $magazine = $registry->getRepository(Magazine::class);


            foreach ($attachments as $attachment) {
                if (count($attachment) != 9) {
                    $lowAttach = $this->getParameter('low_attach');
                    file_put_contents($lowAttach, json_encode($attachment)."\n\n", FILE_APPEND);
                    continue;
                }

                // $product = $magazine->findOneBy(['CodeSAP' => $attachment['cell matnr']]);

                $attach = $this->getParameter('attach');
                file_put_contents($attach, json_encode($attachment));

                // if (is_null($product)) {
                    /** @var Magazine $product */
                    $product = new Magazine();

                    $product->setCodeSAP($attachment['cell matnr']);
                    $product->setCode($attachment['cell nn']);
                    $product->setDescription($attachment['cell descr']);
                // }

                $product->setMinStakePackage($attachment['cell pack']);
                $product->setWarehouse($attachment['cell stock qty']);
                $product->setNextDelivery($attachment['cell stock expect']);
                $product->setPriceWithoutNDS($attachment['cell rub']);
                $product->setNDS($attachment['cell nds']);
                $product->setPriceWithNDS($attachment['cell rub_nds']);
                $product->setUpdated(new \DateTime(date('Y-m-d H:i:s', strtotime('+3 hours'))));

                $magazine->save($product, true);
            }
            return new JsonResponse(['message' => 'Добавлены и обновлены данные в магазине.', 'status' => 200]);
        }

        return new JsonResponse(['message' => 'Недостаточно необходимых параметров.']);
    }
}
