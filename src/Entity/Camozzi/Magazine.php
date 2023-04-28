<?php

namespace App\Entity\Camozzi;

use App\Repository\Camozzi\MagazineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MagazineRepository::class)]
class Magazine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $CodeSAP = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Code = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MinStakePackage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Warehouse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NextDelivery = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PriceWithoutNDS = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NDS = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PriceWithNDS = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Updated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeSAP(): ?string
    {
        return $this->CodeSAP;
    }

    public function setCodeSAP(string $CodeSAP): self
    {
        $this->CodeSAP = $CodeSAP;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getMinStakePackage(): ?string
    {
        return $this->MinStakePackage;
    }

    public function setMinStakePackage(?string $MinStakePackage): self
    {
        $this->MinStakePackage = $MinStakePackage;

        return $this;
    }

    public function getWarehouse(): ?string
    {
        return $this->Warehouse;
    }

    public function setWarehouse(string $Warehouse): self
    {
        $this->Warehouse = $Warehouse;

        return $this;
    }

    public function getNextDelivery(): ?string
    {
        return $this->NextDelivery;
    }

    public function setNextDelivery(string $NextDelivery): self
    {
        $this->NextDelivery = $NextDelivery;

        return $this;
    }

    public function getPriceWithoutNDS(): ?string
    {
        return $this->PriceWithoutNDS;
    }

    public function setPriceWithoutNDS(string $PriceWithoutNDS): self
    {
        $this->PriceWithoutNDS = $PriceWithoutNDS;

        return $this;
    }

    public function getNDS(): ?string
    {
        return $this->NDS;
    }

    public function setNDS(string $NDS): self
    {
        $this->NDS = $NDS;

        return $this;
    }

    public function getPriceWithNDS(): ?string
    {
        return $this->PriceWithNDS;
    }

    public function setPriceWithNDS(string $PriceWithNDS): self
    {
        $this->PriceWithNDS = $PriceWithNDS;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->Updated;
    }

    public function setUpdated(?\DateTimeInterface $Updated): self
    {
        $this->Updated = $Updated;

        return $this;
    }
}
