<?php

namespace App\Entity;

use App\Repository\UserDossierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity(repositoryClass: UserDossierRepository::class)]
class UserDossier
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'dossier')]
    private $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ManyToOne;

    #[ORM\ManyToOne(targetEntity: Dossier::class, inversedBy: 'userDossiers', cascade: ['persist'])]
    private $dossier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $profil;


    #[ORM\Column(type: 'text', nullable: true)]
    private $instructions;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateAffectation;


    #[ORM\Column(type: 'integer', nullable: true)]
    private $delai;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nature;

    /**
     * UserDossier constructor.
     */
    public function __construct()
    {
        $this->dateAffectation= new \DateTime();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getManyToOne(): ?string
    {
        return $this->ManyToOne;
    }

    public function setManyToOne(?string $ManyToOne): self
    {
        $this->ManyToOne = $ManyToOne;

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

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(?string $profil): self
    {
        $this->profil = $profil;

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


    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getDelai(): ?int
    {
        return $this->delai;
    }

    public function setDelai(int $delai): self
    {
        $this->delai = $delai;

        return $this;
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

}
