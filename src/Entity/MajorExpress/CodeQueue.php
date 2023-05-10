<?php

namespace App\Entity\MajorExpress;

use App\Repository\MajorExpress\CodeQueueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodeQueueRepository::class)]
class CodeQueue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $Code = null;

    #[ORM\Column]
    private ?int $Status = null;

    #[ORM\Column]
    private int $RequestCount = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Updated = null;

    #[ORM\OneToMany(mappedBy: 'Code', targetEntity: Invoice::class)]
    private Collection $invoice;

    public function __construct()
    {
        $this->invoice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?int
    {
        return $this->Status;
    }

    public function setStatus(int $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

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

    public function getRequestCount(): ?int
    {
        return $this->RequestCount;
    }

    public function setRequestCount(int $RequestCount): self
    {
        $this->RequestCount = $RequestCount;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoice(): Collection
    {
        return $this->invoice;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoice->contains($invoice)) {
            $this->invoice->add($invoice);
            $invoice->setCode($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoice->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCode() === $this) {
                $invoice->setCode(null);
            }
        }

        return $this;
    }
}
