<?php

namespace App\Entity;

use App\Repository\AudienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: AudienceRepository::class)]
class Audience
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;



    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateAudience;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avisAudience;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date;

    #[ORM\ManyToOne(targetEntity: Date::class, inversedBy: 'audiences')]
    private $dateDate;

    #[ORM\ManyToMany(targetEntity: Dossier::class, mappedBy: 'audience')]
    private $dossiers;

    #[ORM\Column(type: 'time', nullable: true)]
    private $heureAudience;

    public function __construct()
    {
        $this->dossiers = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }



    public function getDateAudience(): ?\DateTimeInterface
    {
        return $this->dateAudience;
    }

    public function setDateAudience(?\DateTimeInterface $dateAudience): self
    {
        $this->dateAudience = $dateAudience;

        return $this;
    }

    public function getAvisAudience(): ?string
    {
        return $this->avisAudience;
    }

    public function setAvisAudience(?string $avisAudience): self
    {
        $this->avisAudience = $avisAudience;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    public function getDateDate(): ?Date
    {
        return $this->dateDate;
    }

    public function setDateDate(?Date $dateDate): self
    {
        $this->dateDate = $dateDate;

        return $this;
    }

    /**
     * @return Collection<int, Dossier>
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->addAudience($this);
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossiers->removeElement($dossier)) {
            $dossier->removeAudience($this);
        }

        return $this;
    }

    public function getHeureAudience(): ?\DateTimeInterface
    {
        return $this->heureAudience;
    }

    public function setHeureAudience(?\DateTimeInterface $heureAudience): self
    {
        $this->heureAudience = $heureAudience;

        return $this;
    }
}
