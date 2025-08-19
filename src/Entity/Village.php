<?php

namespace App\Entity;

use App\Repository\VillageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VillageRepository::class)]
class Village
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libVillage;


    #[ORM\ManyToOne(targetEntity: Arrondissement::class, inversedBy: 'villages')]
    private $arrondissement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getlibVillage(): ?string
    {
        return $this->libVillage;
    }

    public function setlibVillage(string $libVillage): self
    {
        $this->libVillage = $libVillage;

        return $this;
    }






    public function getArrondissement(): ?Arrondissement
    {
        return $this->arrondissement;
    }

    public function setArrondissement(?Arrondissement $arrondissement): self
    {
        $this->arrondissement = $arrondissement;

        return $this;
    }
}
