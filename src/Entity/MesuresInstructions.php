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

    #[ORM\ManyToOne(inversedBy: 'mesuresInstructions')]
    private ?Instructions $instruction = null;
    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface  $createdAt;

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

    #[ORM\Column(type:'datetime')]
    private  \DateTimeInterface $termineAt ;

    #[ORM\Column(nullable: true)]
    private ?bool $alerteEnvoyee = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Observations = null;



    public function __construct()
    {
        $this->createdAt = new \DateTime(); // Date de création = maintenant
        $this->termineAt = new \DateTime(); // Empêche NULL

    }

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

    /**
     * @return bool
     */
    public function isAlerteEnvoyee()
    {
        return $this->alerteEnvoyee;
    }

    /**
     * @param bool $alerteEnvoyee
     */
    public function setAlerteEnvoyee($alerteEnvoyee)
    {
        $this->alerteEnvoyee = $alerteEnvoyee;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTermineAt()
    {
        return $this->termineAt;
    }

    /**
     * @param \DateTimeInterface|null $termineAt
     */
    public function setTermineAt($termineAt)
    {
        $this->termineAt = $termineAt;
    }

    public function getInstruction(): ?Instructions
    {
        return $this->instruction;
    }

    public function setInstruction(?Instructions $instruction): static
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->Observations;
    }

    public function setObservations(?string $Observations): static
    {
        $this->Observations = $Observations;

        return $this;
    }


 public function getDelais()
 {
     if ($this->instruction){
         return $this->instruction->getDelais();
     }

     return null;

 }





}
