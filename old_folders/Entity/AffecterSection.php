<?php

namespace App\Entity;

use App\Repository\AffecterSectionRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: AffecterSectionRepository::class)]
class AffecterSection
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateAffectation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Motif;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $delaiTraitement;

    #[ORM\OneToOne(targetEntity: Dossier::class, inversedBy: 'affecterSection', cascade: ['persist', 'remove'])]
    private $dossier;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'Greffiers')]
    private $greffier;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'affecterConseil')]
    private $conseillerRapporteur;

    #[ORM\ManyToOne(targetEntity: Section::class)]
    private $section;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->dateAffectation;
    }

    public function setDateAffectation(?\DateTimeInterface $dateAffectation): self
    {
        $this->dateAffectation = $dateAffectation;
        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->Motif;
    }

    public function setMotif(?string $Motif): self
    {
        $this->Motif = $Motif;
        return $this;
    }

    public function getDelaiTraitement(): ?int
    {
        return $this->delaiTraitement;
    }

    public function setDelaiTraitement(?int $delaiTraitement): self
    {
        $this->delaiTraitement = $delaiTraitement;
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

    public function getGreffier(): ?User
    {
        return $this->greffier;
    }

    public function setGreffier(?User $greffier): self
    {
        $this->greffier = $greffier;
        return $this;
    }

    public function getConseillerRapporteur(): ?User
    {
        return $this->conseillerRapporteur;
    }

    public function setConseillerRapporteur(?User $conseillerRapporteur): self
    {
        $this->conseillerRapporteur = $conseillerRapporteur;
        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;
        return $this;
    }
}