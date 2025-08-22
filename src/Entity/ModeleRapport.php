<?php

namespace App\Entity;

use App\Repository\ModeleRapportRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: ModeleRapportRepository::class)]
class ModeleRapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomFichier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Structure $structure = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Section $section = null;

    #[ORM\Column(length: 255)]
    private ?string $fichier = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $update_at = null;

    #[ORM\Column(length: 30)]
    private ?string $typeRapport = null;

    #[ORM\OneToMany(targetEntity: Rapport::class, mappedBy: 'modeleRapport')]
    private Collection $rapports;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): static
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): static
    {
        $this->structure = $structure;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): static
    {
        $this->section = $section;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): static
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeImmutable $update_at): static
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getTypeRapport(): ?string
    {
        return $this->typeRapport;
    }

    public function setTypeRapport(string $typeRapport): static
    {
        $this->typeRapport = $typeRapport;

        return $this;
    }

    public function __construct()
    {
        // Initialiser la propriété avec une instance de ArrayCollection
        $this->rapports = new ArrayCollection();
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports->add($rapport);
            $rapport->setModeleRapport($this);
        }
        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // Définir le côté propriétaire à null (sauf si déjà changé)
            if ($rapport->getModeleRapport() === $this) {
                $rapport->setModeleRapport(null);
            }
        }
        return $this;
    }
}
