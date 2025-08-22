<?php

namespace App\Entity;

use App\Repository\PiecesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PiecesRepository::class)]
class Pieces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'piecesDoc')]
    private ?Dossier $dossier = null;

    #[ORM\ManyToOne(inversedBy: 'pieces')]
    private ?User $auteur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionPiece = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updadedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $naturePiece = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDescriptionPiece(): ?string
    {
        return $this->descriptionPiece;
    }

    public function setDescriptionPiece(?string $descriptionPiece): static
    {
        $this->descriptionPiece = $descriptionPiece;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdadedAt(): ?\DateTimeImmutable
    {
        return $this->updadedAt;
    }

    public function setUpdadedAt(?\DateTimeImmutable $updadedAt): static
    {
        $this->updadedAt = $updadedAt;

        return $this;
    }

    public function getNaturePiece(): ?string
    {
        return $this->naturePiece;
    }

    public function setNaturePiece(?string $naturePiece): static
    {
        $this->naturePiece = $naturePiece;

        return $this;
    }

    public function getRapportFichier(): ?string
    {
        return 'https://' . $_SERVER['SERVER_NAME']. '/uploads/piecesJointes/' . $this->url;
    }
}
