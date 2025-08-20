<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    // Constantes pour les statuts
    public const STATUT_BROUILLON = 'brouillon';
    public const STATUT_EN_COURS = 'en_cours';
    public const STATUT_FINALISE = 'finalise';
    public const STATUT_ARCHIVE = 'archive';

    public const TYPE_DECHEANCE = 'Déchéance';
    public const TYPE_FORCLUSION = 'Forclusion';
    public const TYPE_FOND = 'Fond';


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ModeleRapport::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ModeleRapport $modeleRapport = null;


    /**
 * @ORM\OneToOne(targetEntity=Dossier::class, inversedBy="rapport")
 * @ORM\JoinColumn(nullable=false)
 */
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dossier $dossier = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private $fichier;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $update_at = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rapports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $created_by = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $donnees = [];

    #[ORM\Column(type: Types::STRING, length: 20, options: ['default' => self::STATUT_BROUILLON])]
    private string $statut = self::STATUT_BROUILLON;

    #[ORM\Column(length: 20, nullable: false)]
    private ?string $typeRapport = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeleRapport(): ?ModeleRapport
    {
        return $this->modeleRapport;
    }

    public function setModeleRapport(?ModeleRapport $modeleRapport): self
    {
        $this->modeleRapport = $modeleRapport;
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

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): static
    {
        $this->created_by = $created_by;
        return $this;
    }

    public function getDonnees(): ?array
    {
        return $this->donnees;
    }

    public function setDonnees(?array $donnees): self
    {
        $this->donnees = $donnees;
        return $this;
    }

    public function getDonnee(string $key): mixed
    {
        return $this->donnees[$key] ?? null;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        if (!in_array($statut, [
            self::STATUT_BROUILLON,
            self::STATUT_EN_COURS,
            self::STATUT_FINALISE,
            self::STATUT_ARCHIVE
        ])) {
            throw new \InvalidArgumentException("Statut invalide");
        }
        
        $this->statut = $statut;
        return $this;
    }

    public function isModified(): bool
    {
        return $this->update_at !== null;
    }

    public function markAsUpdated(): void
    {
        $this->update_at = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->id ? 'Rapport #'.$this->id : 'Nouveau rapport';
    }

    /**
     * @ORM\PreRemove
     */
    public function preRemove(): void
    {
        // Cette méthode sera appelée avant la suppression par Doctrine
        $this->setDossier(null); // Détache le rapport du dossier
    }

    public function getTypeRapport(): ?string
    {
        return $this->typeRapport;
    }

    public function setTypeRapport(string $typeRapport): static
    {
        if (!in_array($typeRapport, [self::TYPE_DECHEANCE, self::TYPE_FORCLUSION, self::TYPE_FOND])) {
            throw new \InvalidArgumentException("Type de rapport invalide");
        }
        
        $this->typeRapport = $typeRapport;
        return $this;
    }

}