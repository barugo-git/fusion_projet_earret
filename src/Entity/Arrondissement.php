<?php

namespace App\Entity;

use App\Repository\ArrondissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArrondissementRepository::class)]
class Arrondissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Commune::class, inversedBy: 'arrondissements')]
    private $commune;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libArrond;



    #[ORM\OneToMany(targetEntity: Village::class, mappedBy: 'arrondissement')]
    private $villages;


    #[ORM\OneToMany(mappedBy: 'localite', targetEntity: Partie::class)]
    private $partie;

    public function __construct()
    {

        $this->villages = new ArrayCollection();
        $this->partie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getlibArrond(): ?string
    {
        return $this->libArrond;
    }

    public function setlibArrond(?string $libArrond): self
    {
        $this->libArrond = $libArrond;

        return $this;
    }



    /**
     * @return Collection<int, Village>
     */
    public function getVillages(): Collection
    {
        return $this->villages;
    }

    public function addVillage(Village $village): self
    {
        if (!$this->villages->contains($village)) {
            $this->villages[] = $village;
            $village->setArrondissement($this);
        }

        return $this;
    }

    public function removeVillage(Village $village): self
    {
        if ($this->villages->removeElement($village)) {
            // set the owning side to null (unless already changed)
            if ($village->getArrondissement() === $this) {
                $village->setArrondissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Partie>
     */
    public function getPartie(): Collection
    {
        return $this->partie;
    }

    public function addPartie(Partie $requerant): self
    {
        if (!$this->partie->contains($requerant)) {
            $this->partie[] = $requerant;
            $requerant->setLocalite($this);
        }

        return $this;
    }

    public function removePartie(Partie $requerant): self
    {
        if ($this->partie->removeElement($requerant)) {
            // set the owning side to null (unless already changed)
            if ($requerant->getLocalite() === $this) {
                $requerant->setLocalite(null);
            }
        }

        return $this;
    }
    public function getLibelle(){
        return $this->libArrond;
    }
}
