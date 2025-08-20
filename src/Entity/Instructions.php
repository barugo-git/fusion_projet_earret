<?php

namespace App\Entity;

use App\Repository\InstructionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: InstructionsRepository::class)]
class Instructions
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    private ?int $delais = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = true;

    /**
     * @var Collection<int, MesuresInstructions>
     */
    #[ORM\OneToMany(mappedBy: 'instruction', targetEntity: MesuresInstructions::class)]
    private Collection $mesuresInstructions;

    public function __construct()
    {
        $this->mesuresInstructions = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDelais(): ?int
    {
        return $this->delais;
    }

    public function setDelais(?int $delais): static
    {
        $this->delais = $delais;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, MesuresInstructions>
     */
    public function getMesuresInstructions(): Collection
    {
        return $this->mesuresInstructions;
    }

    public function addMesuresInstruction(MesuresInstructions $mesuresInstruction): static
    {
        if (!$this->mesuresInstructions->contains($mesuresInstruction)) {
            $this->mesuresInstructions->add($mesuresInstruction);
            $mesuresInstruction->setInstruction($this);
        }

        return $this;
    }

    public function removeMesuresInstruction(MesuresInstructions $mesuresInstruction): static
    {
        if ($this->mesuresInstructions->removeElement($mesuresInstruction)) {
            // set the owning side to null (unless already changed)
            if ($mesuresInstruction->getInstruction() === $this) {
                $mesuresInstruction->setInstruction(null);
            }
        }

        return $this;
    }

    public function getLibelleInstruction(): ?string {
        return $this->libelle."  ".$this->getDelais()." jours";
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->libelle;
    }


}
