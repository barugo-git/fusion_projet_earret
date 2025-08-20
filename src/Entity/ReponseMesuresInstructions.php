<?php

namespace App\Entity;

use App\Repository\ReponseMesuresInstructionsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: ReponseMesuresInstructionsRepository::class)]
class ReponseMesuresInstructions
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\OneToOne(targetEntity: MesuresInstructions::class, inversedBy: 'reponses', cascade: ['persist', 'remove'])]
    private $mesure;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $reponse;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $DateMiseDirective;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateNotification = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $reponsePartie;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $termine;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getMesure(): ?MesuresInstructions
    {
        return $this->mesure;
    }

    public function setMesure(?MesuresInstructions $mesure): self
    {
        $this->mesure = $mesure;
        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;
        return $this;
    }

    public function getDateMiseDirective(): ?\DateTimeInterface
    {
        return $this->DateMiseDirective;
    }

    public function setDateMiseDirective(?\DateTimeInterface $DateMiseDirective): self
    {
        $this->DateMiseDirective = $DateMiseDirective;
        return $this;
    }

    public function getDateNotification(): ?\DateTimeImmutable
    {
        return $this->dateNotification;
    }

    public function setDateNotification(\DateTimeImmutable $dateNotification): self
    {
        $this->dateNotification = $dateNotification;
        return $this;
    }

    public function isReponsePartie(): ?bool
    {
        return $this->reponsePartie;
    }

    public function setReponsePartie(?bool $reponsePartie): self
    {
        $this->reponsePartie = $reponsePartie;
        return $this;
    }

    public function isTermine(): ?bool
    {
        return $this->termine;
    }

    public function setTermine(?bool $termine): self
    {
        $this->termine = $termine;
        return $this;
    }
}