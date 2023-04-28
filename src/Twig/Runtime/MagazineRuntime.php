<?php

namespace App\Twig\Runtime;

use App\Entity\Camozzi\Magazine;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Extension\RuntimeExtensionInterface;

class MagazineRuntime implements RuntimeExtensionInterface
{
    private ManagerRegistry $registry;
    public function __construct(ManagerRegistry $registry)
    {
        // Inject dependencies if needed
        $this->registry = $registry;
    }

    public function getMagazineCount()
    {
        $magazine = $this->registry->getRepository(Magazine::class)->getMagazineCount();

        return $magazine['count'];
    }
}
