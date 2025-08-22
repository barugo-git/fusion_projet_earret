<?php

namespace App\Entity;

use App\Repository\AffecterStructureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: AffecterStructureRepository::class)]
class AffecterUser
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

//    #[ORM\ManyToOne(targetEntity: Dossier::class, inversedBy: 'structures')]
//    private $dossier;



    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateAffection;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $motif;

    #[ORM\Column(type: 'date', nullable: true)]
    private $delaiTraitement;



    #[ORM\ManyToOne(inversedBy: 'affecterUsers')]
    private ?User $destinataire = null;

    #[ORM\ManyToOne(inversedBy: 'affecterUsersExpediteur')]
    private ?User $expediteur = null;

    #[ORM\ManyToOne(inversedBy: 'affecterUsers')]
    private ?Dossier $dossier = null;


    public function getId(): ?Uuid
    {
        return $this->id;
    }




    public function getDateAffection(): ?\DateTimeInterface
    {
        return $this->dateAffection;
    }

    public function setDateAffection(?\DateTimeInterface $dateAffection): self
    {
        $this->dateAffection = $dateAffection;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getDelaiTraitement(): ?\DateTimeInterface
    {
        return $this->delaiTraitement;
    }

    public function setDelaiTraitement(?\DateTimeInterface $delaiTraitement): self
    {
        $this->delaiTraitement = $delaiTraitement;

        return $this;
    }


    public function getDestinataire(): ?User
    {
        return $this->destinataire;
    }

    public function setDestinataire(?User $destinataire): static
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getExpediteur(): ?User
    {
        return $this->expediteur;
    }

    public function setExpediteur(?User $expediteur): static
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): static
    {
        $this->dossier = $dossier;

        return $this;
    }


}
