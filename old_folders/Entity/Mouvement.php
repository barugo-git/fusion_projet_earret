<?php

namespace App\Entity;

use App\Repository\MouvementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: MouvementRepository::class)]
class Mouvement
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'mouvements')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'mouvements')]
    private ?Dossier $Dossier = null;

    #[ORM\ManyToOne(inversedBy: 'mouvements')]
    private ?Statut $Statut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateMouvement = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->Dossier;
    }

    public function setDossier(?Dossier $Dossier): static
    {
        $this->Dossier = $Dossier;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->Statut;
    }

    public function setStatut(?Statut $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getDateMouvement(): ?\DateTimeInterface
    {
        return $this->dateMouvement;
    }

    public function setDateMouvement(\DateTimeInterface $dateMouvement): static
    {
        $this->dateMouvement = $dateMouvement;

        return $this;
    }
}
