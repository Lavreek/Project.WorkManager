<?php

namespace App\Entity\MajorExpress;

use App\Repository\MajorExpress\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[ORM\UniqueConstraint(name: 'idx_id_fhash', columns: ['id', 'file_hash'])]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\ManyToOne(targetEntity: CodeQueue::class, inversedBy: 'invoice')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $FileType = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $FileContent = null;

    #[ORM\Column(length: 255)]
    private ?string $FileHash = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Updated = null;

    #[ORM\ManyToOne(inversedBy: 'invoice')]
    private ?CodeQueue $Code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileType(): ?string
    {
        return $this->FileType;
    }

    public function setFileType(string $FileType): self
    {
        $this->FileType = $FileType;

        return $this;
    }

    public function getFileContent(): ?string
    {
        return $this->FileContent;
    }

    public function setFileContent(string $FileContent): self
    {
        $this->FileContent = $FileContent;

        return $this;
    }

    public function getFileHash(): ?string
    {
        return $this->FileHash;
    }

    public function setFileHash(string $FileHash): self
    {
        $this->FileHash = $FileHash;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->Updated;
    }

    public function setUpdated(\DateTimeInterface $Updated): self
    {
        $this->Updated = $Updated;

        return $this;
    }

    public function getCode(): ?CodeQueue
    {
        return $this->Code;
    }

    public function setCode(?CodeQueue $Code): self
    {
        $this->Code = $Code;

        return $this;
    }
}
