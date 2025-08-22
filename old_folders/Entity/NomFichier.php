<?php

namespace App\Entity;

use App\Repository\NomFichierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NomFichierRepository::class)]
class NomFichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
