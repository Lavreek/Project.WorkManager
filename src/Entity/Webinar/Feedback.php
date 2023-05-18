<?php

namespace App\Entity\Webinar;

use App\Repository\Webinar\FeedbackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
#[ORM\UniqueConstraint(name: 'idx_page_id_email_hash', columns: ['page_id', 'email_hash'])]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $PageID = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EmailHash = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $FormParams = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $RoistatID = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $VisitorInfo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Fingerprint = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $YanUID = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UIP = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Created = null;

    #[ORM\Column(length: 255)]
    private ?string $Boundary = null;

    #[ORM\Column(length: 255)]
    private ?string $Status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageID(): ?int
    {
        return $this->PageID;
    }

    public function setPageID(int $PageID): self
    {
        $this->PageID = $PageID;

        return $this;
    }

    public function getEmailHash(): ?string
    {
        return $this->EmailHash;
    }

    public function setEmailHash(?string $EmailHash): self
    {
        $this->EmailHash = $EmailHash;

        return $this;
    }

    public function getFormParams(): ?string
    {
        return $this->FormParams;
    }

    public function setFormParams(?string $FormParams): self
    {
        $this->FormParams = $FormParams;

        return $this;
    }

    public function getRoistatID(): ?string
    {
        return $this->RoistatID;
    }

    public function setRoistatID(?string $RoistatID): self
    {
        $this->RoistatID = $RoistatID;

        return $this;
    }

    public function getVisitorInfo(): ?string
    {
        return $this->VisitorInfo;
    }

    public function setVisitorInfo(?string $VisitorInfo): self
    {
        $this->VisitorInfo = $VisitorInfo;

        return $this;
    }

    public function getFingerprint(): ?string
    {
        return $this->Fingerprint;
    }

    public function setFingerprint(?string $Fingerprint): self
    {
        $this->Fingerprint = $Fingerprint;

        return $this;
    }

    public function getYanUID(): ?string
    {
        return $this->YanUID;
    }

    public function setYanUID(?string $YanUID): self
    {
        $this->YanUID = $YanUID;

        return $this;
    }

    public function getUIP(): ?string
    {
        return $this->UIP;
    }

    public function setUIP(?string $UIP): self
    {
        $this->UIP = $UIP;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->Created;
    }

    public function setCreated(\DateTimeInterface $Created): self
    {
        $this->Created = $Created;

        return $this;
    }

    public function getBoundary(): ?string
    {
        return $this->Boundary;
    }

    public function setBoundary(string $Boundary): self
    {
        $this->Boundary = $Boundary;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }
}
