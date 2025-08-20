<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libcom;

    /**
     * @return mixed
     */
    public function getLibcom()
    {
        return $this->libcom;
    }

    /**
     * @param mixed $libcom
     */
    public function setLibcom($libcom): void
    {
        $this->libcom = $libcom;
    }


    #[ORM\ManyToOne(targetEntity: Departement::class, inversedBy: 'communes')]
    private $departement;

    #[ORM\OneToMany(targetEntity: Arrondissement::class, mappedBy: 'commune')]
    private $arrondissements;

    public function __construct()
    {
        $this->arrondissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Arrondissement>
     */
    public function getArrondissements(): Collection
    {
        return $this->arrondissements;
    }

    public function addArrondissement(Arrondissement $arrondissement): self
    {
        if (!$this->arrondissements->contains($arrondissement)) {
            $this->arrondissements[] = $arrondissement;
            $arrondissement->setCommune($this);
        }

        return $this;
    }

    public function removeArrondissement(Arrondissement $arrondissement): self
    {
        if ($this->arrondissements->removeElement($arrondissement)) {
            // set the owning side to null (unless already changed)
            if ($arrondissement->getCommune() === $this) {
                $arrondissement->setCommune(null);
            }
        }

        return $this;
    }

    public function getLibelle(){
        return $this->libcom;
    }
}
