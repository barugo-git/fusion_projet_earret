<?php

namespace App\Entity;

use App\Repository\DeliberationDossiersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: DeliberationDossiersRepository::class)]
class DeliberationDossiers
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: Dossier::class, inversedBy: 'deliberation')]
    private $dossier;

    #[ORM\Column(type: 'text')]
    private $avisDeliberation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $datetime;

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

    public function getAvisDeliberation(): ?string
    {
        return $this->avisDeliberation;
    }

    public function setAvisDeliberation(string $avisDeliberation): self
    {
        $this->avisDeliberation = $avisDeliberation;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
}
