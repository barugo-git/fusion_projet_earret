<?php

namespace App\Entity;

use App\Repository\AffecterStructureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: AffecterStructureRepository::class)]
class AffecterStructure
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: Dossier::class, inversedBy: 'structures')]
    private $dossier;

    #[ORM\ManyToOne(targetEntity: Structure::class, inversedBy: 'affecterStructures')]
    private $structure;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateAffection;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $motif;

    #[ORM\Column(type: 'date', nullable: true)]
    private $delaiTraitement;

    #[ORM\ManyToOne(targetEntity: Structure::class, inversedBy: 'de')]
    private $de;

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
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

    public function getDe(): ?Structure
    {
        return $this->de;
    }

    public function setDe(?Structure $de): self
    {
        $this->de = $de;

        return $this;
    }
}
