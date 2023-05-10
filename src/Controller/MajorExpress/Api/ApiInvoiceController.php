<?php

namespace App\Controller\MajorExpress\Api;

use App\Entity\MajorExpress\CodeQueue;
use App\Entity\MajorExpress\Invoice;
use App\Repository\MajorExpress\CodeQueueRepository;
use App\Repository\MajorExpress\InvoiceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiInvoiceController extends AbstractController
{
    #[Route('/api/majorexpress/invoice/get', name: 'api_majorexpress_invoice_get', methods: ['POST'])]
    public function invoiceGet(Request $request, ManagerRegistry $registry): JsonResponse
    {
        if ($_ENV['APP_SECRET'] !== $request->request->get('APP_SECRET')) {
            return new JsonResponse(['error' => 'Запрос по данному адресу недоступен.']);
        }

        $requestData = $request->request->all();

        if (['type' => $type, 'code' => $code] = $requestData) {
            $majorRepository = $this->getParameter('major_invoice');

            if (isset($requestData['full']) and $requestData['full'] and $type === "json") {
                $file = $majorRepository . "/" . $code . "/unity.json";

                return $this->json(json_decode(file_get_contents($file), true));
            }

            if (['option' => $option, 'block' => $block] = $requestData) {
                if (array_search($type, ['json', 'png']) !== false) {
                    $file = $majorRepository . "/" . $code . "/$option-$block.$type";
                    return $this->json(json_decode(file_get_contents($file), true));
                }
            }
        }

        return new JsonResponse(['error' => 'Недостаточно необходимых параметров.']);
    }

    #[Route('/api/majorexpress/invoice/flush', name: 'api_majorexpress_invoice_flush', methods: ['POST'])]
    public function invoiceFlush(Request $request, ManagerRegistry $registry): JsonResponse
    {
        if ($_ENV['APP_SECRET'] !== $request->request->get('APP_SECRET')) {
            return new JsonResponse(['error' => 'Запрос по данному адресу недоступен.']);
        }

        $requestData = $request->request->all();

        if ($code = $requestData['code'] and $attach = $requestData['attachments']) {
            $majorResourceRepo = $this->getParameter('major_invoice');
            $majorCodeRepo = $majorResourceRepo . "/" . $code;

            /** @var CodeQueueRepository $queryRepo */
            $queryRepo = $registry->getRepository(CodeQueue::class);

            $query = $queryRepo->findOneBy(['Code' => $code]);

            if (!is_null($query)) {
                try {
                    foreach ([$majorResourceRepo, $majorCodeRepo] as $dir) {
                        if (!is_dir($dir)) {
                            mkdir($dir);
                        }
                    }

                    $file = $requestData['file'];
                    file_put_contents($majorCodeRepo . "/" . $attach['basename'], $file);

                } catch (\Exception $e) {
                    file_put_contents($this->getParameter('file_exceptions'), $e->getMessage() . "\n\n", FILE_APPEND);
                }

                /** @var InvoiceRepository $invoiceRepository */
                $invoiceRepository = $registry->getRepository(Invoice::class);

                $invoice = $invoiceRepository->findOneBy(['Code' => $query, 'FileContent' => $attach['basename']]);

                if (is_null($invoice)) {
                    $invoice = new Invoice();
                    $invoice->setCode($query);
                    $invoice->setFileContent($attach['basename']);
                    $invoice->setFileType($attach['extension']);
                }

                $invoice->setFileHash(hash('sha256', $requestData['file']));
                $invoice->setUpdated(new \DateTime(date('Y-m-d H:i:s')));

                $invoiceRepository->save($invoice, true);

                return new JsonResponse(['message' => 'Файл добавлен']);
            }
        }

        return new JsonResponse(['error' => 'Недостаточно необходимых параметров.']);
    }
}
