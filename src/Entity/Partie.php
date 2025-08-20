<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenoms;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $sexe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adresse;

    #[ORM\OneToMany(targetEntity: Dossier::class, mappedBy: 'requerant')]
    private $dossiersRequerant;


    #[ORM\ManyToOne(targetEntity: Arrondissement::class, inversedBy: 'partie')]
    private $localite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $intitule;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    /**
     * @var Collection<int, Dossier>
     */
    #[ORM\OneToMany(mappedBy: 'defendeur', targetEntity: Dossier::class)]
    private Collection $dossiersDefendeur;

    /**
     * @var Collection<int, ConseillerPartie>
     */
    #[ORM\OneToMany(mappedBy: 'partie', targetEntity: ConseillerPartie::class,cascade: ['persist'])]
    private Collection $conseiller;

    /**
     * @var Collection<int, Representant>
     */
    #[ORM\OneToMany(mappedBy: 'partie', targetEntity: Representant::class)]
    private Collection $representants;

    public function __construct()
    {
        $this->dossiersRequerant = new ArrayCollection();
        $this->dossiersDefendeur = new ArrayCollection();
        $this->conseiller = new ArrayCollection();
        $this->representants = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(?string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Dossier>
     */
    public function getDossiersRequerant(): Collection
    {
        return $this->dossiersRequerant;
    }

    public function addDossierRequerant(Dossier $dossierRequerant): self
    {
        if (!$this->dossiersRequerant->contains($dossierRequerant)) {
            $this->dossiersRequerant[] = $dossierRequerant;
            $dossierRequerant->setRequerant($this);
        }

        return $this;
    }

    public function removeDossierRequerant(Dossier $dossierRequerant): self
    {
        if ($this->dossiersRequerant->removeElement($dossierRequerant)) {
            // set the owning side to null (unless already changed)
            if ($dossierRequerant->getRequerant() === $this) {
                $dossierRequerant->setRequerant(null);
            }
        }

        return $this;
    }

    public function getLocalite(): ?Arrondissement
    {
        return $this->localite;
    }

    public function setLocalite(?Arrondissement $localite): self
    {
        $this->localite = $localite;

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

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Dossier>
     */
    public function getDossiersDefendeur(): Collection
    {
        return $this->dossiersDefendeur;
    }

    public function addDossiersDefendeur(Dossier $dossiersDefendeur): static
    {
        if (!$this->dossiersDefendeur->contains($dossiersDefendeur)) {
            $this->dossiersDefendeur->add($dossiersDefendeur);
            $dossiersDefendeur->setDefendeur($this);
        }

        return $this;
    }

    public function removeDossiersDefendeur(Dossier $dossiersDefendeur): static
    {
        if ($this->dossiersDefendeur->removeElement($dossiersDefendeur)) {
            // set the owning side to null (unless already changed)
            if ($dossiersDefendeur->getDefendeur() === $this) {
                $dossiersDefendeur->setDefendeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConseillerPartie>
     */
    public function getConseiller(): Collection
    {
        return $this->conseiller;
    }

    public function addConseiller(ConseillerPartie $conseiller): static
    {
        if (!$this->conseiller->contains($conseiller)) {
            $this->conseiller->add($conseiller);
            $conseiller->setPartie($this);
        }

        return $this;
    }

    public function removeConseiller(ConseillerPartie $conseiller): static
    {
        if ($this->conseiller->removeElement($conseiller)) {
            // set the owning side to null (unless already changed)
            if ($conseiller->getPartie() === $this) {
                $conseiller->setPartie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Representant>
     */
    public function getRepresentants(): Collection
    {
        return $this->representants;
    }

    public function addRepresentant(Representant $representant): static
    {
        if (!$this->representants->contains($representant)) {
            $this->representants->add($representant);
            $representant->setPartie($this);
        }

        return $this;
    }

    public function removeRepresentant(Representant $representant): static
    {
        if ($this->representants->removeElement($representant)) {
            // set the owning side to null (unless already changed)
            if ($representant->getPartie() === $this) {
                $representant->setPartie(null);
            }
        }

        return $this;
    }

    public function getNomComplet(): string
    {
        return $this->nom . ' ' . $this->prenoms;
    }
}