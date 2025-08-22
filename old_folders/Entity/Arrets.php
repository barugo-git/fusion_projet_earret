<?php

namespace App\Entity;

use App\Repository\ArretsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: ArretsRepository::class)]
class Arrets
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'arrets')]
    private $CreatedBy;

    #[ORM\ManyToOne(targetEntity: Dossier::class, inversedBy: 'arrets')]
    private $dossier;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateArret;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $titrage;

    #[ORM\Column(type: 'text', nullable: true)]
    private $resume;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $arret;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numArret;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $forclusion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCreatedBy(): ?User
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?User $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getDateArret(): ?\DateTimeInterface
    {
        return $this->dateArret;
    }

    public function setDateArret(?\DateTimeInterface $dateArret): self
    {
        $this->dateArret = $dateArret;

        return $this;
    }

    public function getTitrage(): ?string
    {
        return $this->titrage;
    }

    public function setTitrage(?string $titrage): self
    {
        $this->titrage = $titrage;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getArret(): ?string
    {
        return $this->arret;
    }

    public function setArret(?string $arret): self
    {
        $this->arret = $arret;

        return $this;
    }

    public function getNumArret(): ?string
    {
        return $this->numArret;
    }

    public function setNumArret(?string $numArret): self
    {
        $this->numArret = $numArret;

        return $this;
    }

    public function getForclusion(): ?string
    {
        return $this->forclusion;
    }

    public function setForclusion(?string $forclusion): self
    {
        $this->forclusion = $forclusion;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
