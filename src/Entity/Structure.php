<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private $codeStructure;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\OneToMany(targetEntity: Section::class, mappedBy: 'structure')]
    private $sections;

    #[ORM\OneToMany(targetEntity: AffecterStructure::class, mappedBy: 'structure')]
    private $affecterStructures;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'structure')]
    private $users;

    #[ORM\OneToMany(targetEntity: Dossier::class, mappedBy: 'structure')]
    private $dossiers;

    #[ORM\OneToMany(targetEntity: AffecterStructure::class, mappedBy: 'de')]
    private $de;

    /**
     * @var Collection<int, Salle>
     */
    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: Salle::class)]
    private Collection $salles;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->affecterStructures = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->dossiers = new ArrayCollection();
        $this->de = new ArrayCollection();
        $this->salles = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCodeStructure(): ?string
    {
        return $this->codeStructure;
    }

    public function setCodeStructure(?string $codeStructure): self
    {
        $this->codeStructure = $codeStructure;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setStructure($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getStructure() === $this) {
                $section->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AffecterStructure>
     */
    public function getAffecterStructures(): Collection
    {
        return $this->affecterStructures;
    }

    public function addAffecterStructure(AffecterStructure $affecterStructure): self
    {
        if (!$this->affecterStructures->contains($affecterStructure)) {
            $this->affecterStructures[] = $affecterStructure;
            $affecterStructure->setStructure($this);
        }

        return $this;
    }

    public function removeAffecterStructure(AffecterStructure $affecterStructure): self
    {
        if ($this->affecterStructures->removeElement($affecterStructure)) {
            // set the owning side to null (unless already changed)
            if ($affecterStructure->getStructure() === $this) {
                $affecterStructure->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setStructure($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStructure() === $this) {
                $user->setStructure(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
            $dossier->setStructure($this);
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossiers->removeElement($dossier)) {
            // set the owning side to null (unless already changed)
            if ($dossier->getStructure() === $this) {
                $dossier->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AffecterStructure>
     */
    public function getDe(): Collection
    {
        return $this->de;
    }

    public function addDe(AffecterStructure $de): self
    {
        if (!$this->de->contains($de)) {
            $this->de[] = $de;
            $de->setDe($this);
        }

        return $this;
    }

    public function removeDe(AffecterStructure $de): self
    {
        if ($this->de->removeElement($de)) {
            // set the owning side to null (unless already changed)
            if ($de->getDe() === $this) {
                $de->setDe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Salle>
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(Salle $salle): static
    {
        if (!$this->salles->contains($salle)) {
            $this->salles->add($salle);
            $salle->setStructure($this);
        }

        return $this;
    }

    public function removeSalle(Salle $salle): static
    {
        if ($this->salles->removeElement($salle)) {
            // set the owning side to null (unless already changed)
            if ($salle->getStructure() === $this) {
                $salle->setStructure(null);
            }
        }

        return $this;
    }
}
