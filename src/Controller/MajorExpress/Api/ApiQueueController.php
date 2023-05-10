<?php

namespace App\Controller\MajorExpress\Api;

use App\Entity\MajorExpress\CodeQueue;
use App\Repository\MajorExpress\CodeQueueRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiQueueController extends AbstractController
{
    #[Route('/api/majorexpress/queue/create', name: 'api_majorexpress_queue_create')]
    public function queueCreate(Request $request, ManagerRegistry $registry): JsonResponse
    {
        if ($_ENV['APP_SECRET'] !== $request->request->get('APP_SECRET')) {
            return new JsonResponse(['error' => 'Запрос по данному адресу недоступен.']);
        }

        if ($code = $request->request->get('code')) {
            /** @var CodeQueueRepository $queueRepo */
            $queueRepo = $registry->getRepository(CodeQueue::class);

            $queue = $queueRepo->findOneBy(['Code' => $code]);

            if (!is_null($queue)) {
                return new JsonResponse(['message' => 'Код уже существует.']);
            }

            $queue = new CodeQueue();
            $queue->setCode($code);
            $queue->setStatus(1);
            $queue->setRequestCount(0);
            $queue->setCreated(new \DateTime(date('Y-m-d H:i:s')));
            // $queue->setUpdated(new \DateTime(date('Y-m-d H:i:s')));

            $queueRepo->save($queue, true);

            return new JsonResponse(['message' => 'Код добавлен в очередь.']);
        }

        return new JsonResponse(['error' => 'Недостаточно необходимых параметров.']);
    }

    #[Route('/api/majorexpress/queue/get', name: 'api_majorexpress_queue_get', methods: ['POST'])]
    public function queueGet(Request $request, ManagerRegistry $registry): JsonResponse
    {
        if ($_ENV['APP_SECRET'] !== $request->request->get('APP_SECRET')) {
            return new JsonResponse(['error' => 'Запрос по данному адресу недоступен.']);
        }

        /** @var CodeQueueRepository $queueRepo */
        $queueRepo = $registry->getRepository(CodeQueue::class);

        $date = date('Y-m-d H:i:s');
        $nextDate = date('Y-m-d H:i:s', strtotime('+1 day'));

        $queue = $queueRepo->findByDate(new \DateTime($date));

        if (!is_null($queue)) {
            $queue->setRequestCount($queue->getRequestCount() + 1);
            $queue->setUpdated(new \DateTime($nextDate));
            $queueRepo->save($queue, true);

            return new JsonResponse(['code' => $queue->getCode()]);
        }

        return new JsonResponse(['nessage' => 'Код для обновления отсутствует.']);
    }
}
