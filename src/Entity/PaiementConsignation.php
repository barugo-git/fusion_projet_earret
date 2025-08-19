<?php

namespace App\Entity;

use App\Repository\PaiementConsignationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementConsignationRepository::class)]
class PaiementConsignation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'paiementConsignation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dossier $dossier = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $datePaiement = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $preuveConsignation = null;

    #[ORM\Column]
    private ?bool $consignation = null;

    #[ORM\Column(length: 20)]
    private ?string $idTransaction = null;

    #[ORM\Column(length: 30)]
    private ?string $modePaiement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(Dossier $dossier): static
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeImmutable
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeImmutable $datePaiement): static
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getPreuveConsignation(): ?string
    {
        return $this->preuveConsignation;
    }

    public function setPreuveConsignation(string $preuveConsignation): static
    {
        $this->preuveConsignation = $preuveConsignation;

        return $this;
    }

    public function isConsignation(): ?bool
    {
        return $this->consignation;
    }

    public function setConsignation(bool $consignation): static
    {
        $this->consignation = $consignation;

        return $this;
    }

    public function getIdTransaction(): ?string
    {
        return $this->idTransaction;
    }

    public function setIdTransaction(string $idTransaction): static
    {
        $this->idTransaction = $idTransaction;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): static
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }
}
