<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: "Un autre utilisateur s'est déjà inscrit avec cette adresse email, merci de la modifier")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner un email')]
    #[Assert\Email(message: 'Veuillez renseigner un email valide !')]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: 'Veuillez renseigner un mot de passe.')]
    private $password;


    #[Assert\EqualTo(propertyPath: 'password', message: "Vous n'avez pas correctement confirmé votre mot de passe !")]
    public $passwordConfirm;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Vous devez renseigner le nom de famille')]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Vous devez renseigner vos prénoms')]
    private $prenoms;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Vous devez renseigner le numéro de téléphone')]
    private $telephone;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $actif;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastLogin;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Vous devez renseigner le titre')]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $token;

    #[ORM\OneToMany(targetEntity: UserDossier::class, mappedBy: 'user')]
    private $dossier;

    #[ORM\OneToMany(targetEntity: Arrets::class, mappedBy: 'CreatedBy')]
    private $arrets;


    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Structure::class, inversedBy: 'users')]
    private $structure;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'users')]
    private $sections;


    #[ORM\OneToMany(targetEntity: MesuresInstructions::class, mappedBy: 'conseillerRapporteur')]
    private $instructionsCR;

    #[ORM\OneToMany(targetEntity: MesuresInstructions::class, mappedBy: 'greffier', orphanRemoval: true)]
    private $instructionGreffier;

    #[ORM\OneToMany(targetEntity: AffecterSection::class, mappedBy: 'greffier')]
    private $Greffiers;

    #[ORM\OneToMany(targetEntity: AffecterSection::class, mappedBy: 'conseillerRapporteur')]
    private $affecterConseil;

    #[ORM\OneToMany(targetEntity: Log::class, mappedBy: 'user')]
    private $logs;

    #[ORM\Column]
    private ?bool $passwordChangeRequired = true;

    /**
     * @var Collection<int, Dossier>
     */
    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Dossier::class)]
    private Collection $dossiers;

    /**
     * @var Collection<int, AffecterUser>
     */
    #[ORM\OneToMany(mappedBy: 'destinataire', targetEntity: AffecterUser::class)]
    private Collection $affecterUsers;

    /**
     * @var Collection<int, AffecterUser>
     */
    #[ORM\OneToMany(mappedBy: 'expediteur', targetEntity: AffecterUser::class)]
    private Collection $affecterUsersExpediteur;

    /**
     * @var Collection<int, Mouvement>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Mouvement::class)]
    private Collection $mouvements;

    /**
     * @var Collection<int, Pieces>
     */
    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Pieces::class)]
    private Collection $pieces;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;



    public function __construct()
    {
        $this->dossier = new ArrayCollection();
        $this->arrets = new ArrayCollection();

;
        $this->instructionsCR = new ArrayCollection();
        $this->instructionGreffier = new ArrayCollection();
        $this->Greffiers = new ArrayCollection();
        $this->affecterConseil = new ArrayCollection();
        $this->logs = new ArrayCollection();
        $this->passwordChangeRequired = true;
        $this->users = new ArrayCollection();
        $this->dossiers = new ArrayCollection();
        $this->affecterUsers = new ArrayCollection();
        $this->affecterUsersExpediteur = new ArrayCollection();
        $this->mouvements = new ArrayCollection();
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUserInformations(): string {
        return $this->getPrenoms() ." ". $this->getNom();
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(?string $prenoms): self
    {
        $this->prenoms = $prenoms;

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

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, UserDossier>
     */
    public function getDossier(): Collection
    {
        return $this->dossier;
    }

    public function addDossier(UserDossier $dossier): self
    {
        if (!$this->dossier->contains($dossier)) {
            $this->dossier[] = $dossier;
            $dossier->setUser($this);
        }

        return $this;
    }

    public function removeDossier(UserDossier $dossier): self
    {
        if ($this->dossier->removeElement($dossier)) {
            // set the owning side to null (unless already changed)
            if ($dossier->getUser() === $this) {
                $dossier->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Arrets>
     */
    public function getArrets(): Collection
    {
        return $this->arrets;
    }

    public function addArret(Arrets $arret): self
    {
        if (!$this->arrets->contains($arret)) {
            $this->arrets[] = $arret;
            $arret->setCreatedBy($this);
        }

        return $this;
    }

    public function removeArret(Arrets $arret): self
    {
        if ($this->arrets->removeElement($arret)) {
            // set the owning side to null (unless already changed)
            if ($arret->getCreatedBy() === $this) {
                $arret->setCreatedBy(null);
            }
        }

        return $this;
    }



    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function getFullName() {
        return "{$this->prenoms} {$this->nom}";
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * @return Collection<int, AffecterSection>
     */
    public function getAffecterConseil(): Collection
    {
        return $this->affecterConseil;
    }

    public function addAffecterConseil(AffecterSection $affecterConseil): self
    {
        if (!$this->affecterConseil->contains($affecterConseil)) {
            $this->affecterConseil[] = $affecterConseil;
            $affecterConseil->setConseillerRapporteur($this);
        }

        return $this;
    }

    public function removeAffecterConseil(AffecterSection $affecterConseil): self
    {
        if ($this->affecterConseil->removeElement($affecterConseil)) {
            // set the owning side to null (unless already changed)
            if ($affecterConseil->getConseillerRapporteur() === $this) {
                $affecterConseil->setConseillerRapporteur(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, MesuresInstructions>
     */
    public function getInstructionsCR(): Collection
    {
        return $this->instructionsCR;
    }

    public function addInstructionsCR(MesuresInstructions $instructionsCR): self
    {
        if (!$this->instructionsCR->contains($instructionsCR)) {
            $this->instructionsCR[] = $instructionsCR;
            $instructionsCR->setConseillerRapporteur($this);
        }

        return $this;
    }

    public function removeInstructionsCR(MesuresInstructions $instructionsCR): self
    {
        if ($this->instructionsCR->removeElement($instructionsCR)) {
            // set the owning side to null (unless already changed)
            if ($instructionsCR->getConseillerRapporteur() === $this) {
                $instructionsCR->setConseillerRapporteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MesuresInstructions>
     */
    public function getInstructionGreffier(): Collection
    {
        return $this->instructionGreffier;
    }

    public function addInstructionGreffier(MesuresInstructions $instructionGreffier): self
    {
        if (!$this->instructionGreffier->contains($instructionGreffier)) {
            $this->instructionGreffier[] = $instructionGreffier;
            $instructionGreffier->setGreffier($this);
        }

        return $this;
    }

    public function removeInstructionGreffier(MesuresInstructions $instructionGreffier): self
    {
        if ($this->instructionGreffier->removeElement($instructionGreffier)) {
            // set the owning side to null (unless already changed)
            if ($instructionGreffier->getGreffier() === $this) {
                $instructionGreffier->setGreffier(null);
            }
        }

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function getGreffier(): ?AffecterSection
    {
        return $this->Greffier;
    }

    public function setGreffier(?AffecterSection $Greffier): self
    {
        // unset the owning side of the relation if necessary
        if ($Greffier === null && $this->Greffier !== null) {
            $this->Greffier->setGreffier(null);
        }

        // set the owning side of the relation if necessary
        if ($Greffier !== null && $Greffier->getGreffier() !== $this) {
            $Greffier->setGreffier($this);
        }

        $this->Greffier = $Greffier;

        return $this;
    }

    /**
     * @return Collection<int, AffecterSection>
     */
    public function getGreffiers(): Collection
    {
        return $this->Greffiers;
    }

    public function addGreffier(AffecterSection $greffier): self
    {
        if (!$this->Greffiers->contains($greffier)) {
            $this->Greffiers[] = $greffier;
            $greffier->setGreffier($this);
        }

        return $this;
    }

    public function removeGreffier(AffecterSection $greffier): self
    {
        if ($this->Greffiers->removeElement($greffier)) {
            // set the owning side to null (unless already changed)
            if ($greffier->getGreffier() === $this) {
                $greffier->setGreffier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Log>
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setUser($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }

        return $this;
    }


    public function getSections(): ?Section
    {
        return $this->sections;
    }

    public function setSections(?Section $sections): self
    {
        $this->sections = $sections;

        return $this;
    }

    public function isPasswordChangeRequired(): ?bool
    {
        return $this->passwordChangeRequired;
    }

    public function setPasswordChangeRequired(bool $passwordChangeRequired): static
    {
        $this->passwordChangeRequired = $passwordChangeRequired;

        return $this;
    }

    /**
     * @return Collection<int, Dossier>
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    /**
     * @return Collection<int, AffecterUser>
     */
    public function getAffecterUsers(): Collection
    {
        return $this->affecterUsers;
    }

    public function addAffecterUser(AffecterUser $affecterUser): static
    {
        if (!$this->affecterUsers->contains($affecterUser)) {
            $this->affecterUsers->add($affecterUser);
            $affecterUser->setDestinataire($this);
        }

        return $this;
    }

    public function removeAffecterUser(AffecterUser $affecterUser): static
    {
        if ($this->affecterUsers->removeElement($affecterUser)) {
            // set the owning side to null (unless already changed)
            if ($affecterUser->getDestinataire() === $this) {
                $affecterUser->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AffecterUser>
     */
    public function getAffecterUsersExpediteur(): Collection
    {
        return $this->affecterUsersExpediteur;
    }

    public function addAffecterUsersExpediteur(AffecterUser $affecterUsersExpediteur): static
    {
        if (!$this->affecterUsersExpediteur->contains($affecterUsersExpediteur)) {
            $this->affecterUsersExpediteur->add($affecterUsersExpediteur);
            $affecterUsersExpediteur->setExpediteur($this);
        }

        return $this;
    }

    public function removeAffecterUsersExpediteur(AffecterUser $affecterUsersExpediteur): static
    {
        if ($this->affecterUsersExpediteur->removeElement($affecterUsersExpediteur)) {
            // set the owning side to null (unless already changed)
            if ($affecterUsersExpediteur->getExpediteur() === $this) {
                $affecterUsersExpediteur->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mouvement>
     */
    public function getMouvements(): Collection
    {
        return $this->mouvements;
    }

    public function addMouvement(Mouvement $mouvement): static
    {
        if (!$this->mouvements->contains($mouvement)) {
            $this->mouvements->add($mouvement);
            $mouvement->setUser($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): static
    {
        if ($this->mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getUser() === $this) {
                $mouvement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pieces>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Pieces $piece): static
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
            $piece->setAuteur($this);
        }

        return $this;
    }

    public function removePiece(Pieces $piece): static
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getAuteur() === $this) {
                $piece->setAuteur(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

}