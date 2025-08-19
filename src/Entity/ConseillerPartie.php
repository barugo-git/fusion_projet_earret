<?php

namespace App\Entity;

use App\Repository\ConseillerPartieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;


#[ORM\Entity(repositoryClass: ConseillerPartieRepository::class)]
class ConseillerPartie
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    /**
     * @return Uuid|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Uuid|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $nomCabinet;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $nomAvocat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $prenomAvocat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $adresseAvocat;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $updateAt;

    #[ORM\ManyToOne(inversedBy: 'conseiller')]
    private ?Partie $partie = null;

    public function getNomCabinet(): ?string
    {
        return $this->nomCabinet;
    }

    public function setNomCabinet(?string $nomCabinet): self
    {
        $this->nomCabinet = $nomCabinet;

        return $this;
    }

    public function getNomAvocat(): ?string
    {
        return $this->nomAvocat;
    }

    public function setNomAvocat(?string $nomAvocat): self
    {
        $this->nomAvocat = $nomAvocat;

        return $this;
    }

    public function getPrenomAvocat(): ?string
    {
        return $this->prenomAvocat;
    }

    public function setPrenomAvocat(?string $prenomAvocat): self
    {
        $this->prenomAvocat = $prenomAvocat;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresseAvocat(): ?string
    {
        return $this->adresseAvocat;
    }

    public function setAdresseAvocat(?string $adresseAvocat): self
    {
        $this->adresseAvocat = $adresseAvocat;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function infosIdentite()
    {
        return $this->prenomAvocat ." ".$this->nomAvocat." / ".$this->telephone ." - ".$this->email." - nom du cabinet ".$this->nomCabinet;
    }

    public function fullName()
    {
        return $this->prenomAvocat ." ".$this->nomAvocat;
    }

    public function getPartie(): ?Partie
    {
        return $this->partie;
    }

    public function setPartie(?Partie $partie): static
    {
        $this->partie = $partie;

        return $this;
    }
}
