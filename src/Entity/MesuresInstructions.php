<?php

namespace App\Entity;

use App\Repository\MesuresInstructionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: MesuresInstructionsRepository::class)]
class MesuresInstructions
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: Dossier::class, inversedBy: 'mesuresInstructions')]
    private $dossier;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'instructionsCR')]
    private $conseillerRapporteur;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'instructionGreffier')]
    private $greffier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $instruction;

    #[ORM\Column(type: 'integer')]
    private $delais;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date;

    #[ORM\OneToOne(targetEntity: ReponseMesuresInstructions::class, mappedBy: 'mesure', cascade: ['persist', 'remove'])]
    private $reponses;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $partiesConcernes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nature;

    #[ORM\Column(nullable: true)]
    private ?bool $termine = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $termineAt = null;

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

    public function getConseillerRapporteur(): ?User
    {
        return $this->conseillerRapporteur;
    }

    public function setConseillerRapporteur(?User $conseillerRapporteur): self
    {
        $this->conseillerRapporteur = $conseillerRapporteur;

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

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(?string $instruction): self
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getDelais(): ?int
    {
        return $this->delais;
    }

    public function setDelais(int $delais): self
    {
        $this->delais = $delais;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getReponses(): ?ReponseMesuresInstructions
    {
        return $this->reponses;
    }

    public function setReponses(?ReponseMesuresInstructions $reponses): self
    {
        // unset the owning side of the relation if necessary
        if ($reponses === null && $this->reponses !== null) {
            $this->reponses->setMesure(null);
        }

        // set the owning side of the relation if necessary
        if ($reponses !== null && $reponses->getMesure() !== $this) {
            $reponses->setMesure($this);
        }

        $this->reponses = $reponses;

        return $this;
    }

    public function getPartiesConcernes(): ?string
    {
        return $this->partiesConcernes;
    }

    public function setPartiesConcernes(?string $partiesConcernes): self
    {
        $this->partiesConcernes = $partiesConcernes;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function isTermine(): ?bool
    {
        return $this->termine;
    }

    public function setTermine(?bool $termine): static
    {
        $this->termine = $termine;

        return $this;
    }

    public function getTermineAt(): ?\DateTimeInterface
    {
        return $this->termineAt;
    }

    public function setTermineAt(?\DateTimeInterface $termineAt): static
    {
        $this->termineAt = $termineAt;

        return $this;
    }
}
