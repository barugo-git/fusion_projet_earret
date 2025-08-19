<?php

namespace App\Entity;

use App\Repository\DossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: DossierRepository::class)]
class Dossier
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $referenceEnregistrement;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateEnregistrement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $typeDossier;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $referenceDossier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $intituleObjet;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $referenceDossierComplet;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $etatDossier;


    #[ORM\ManyToOne(targetEntity: Objet::class, inversedBy: 'dossiers')]
    private $objet;

    #[ORM\OneToMany(targetEntity: UserDossier::class, mappedBy: 'dossier', cascade: ['persist'])]
    private $userDossiers;

    #[ORM\OneToMany(targetEntity: AffecterStructure::class, mappedBy: 'dossier')]
    private $structures;


    #[ORM\OneToMany(targetEntity: Arrets::class, mappedBy: 'dossier')]
    private $arrets;


    #[ORM\OneToMany(mappedBy: 'dossier', targetEntity: DossierPiecesJointes::class, cascade: ['persist'])]
    private $pieces;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateOuverture;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;


    #[ORM\ManyToOne(targetEntity: Structure::class, inversedBy: 'dossiers')]
    private $structure;

    #[ORM\ManyToMany(targetEntity: Audience::class, inversedBy: 'dossiers', cascade: ['persist'])]
    private $audience;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nature;

    #[ORM\ManyToOne(targetEntity: Provenance::class, inversedBy: 'dossiers')]
    private $provenance;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $autorisation;

    #[ORM\OneToMany(targetEntity: MesuresInstructions::class, mappedBy: 'dossier')]
    private $mesuresInstructions;

    #[ORM\OneToOne(targetEntity: AffecterSection::class, mappedBy: 'dossier', cascade: ['persist', 'remove'])]
    private $affecterSection;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $clos;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateCloture;

    #[ORM\Column(type: 'text', nullable: true)]
    private $motifCloture;

    #[ORM\Column(type: 'text', nullable: true)]
    private $annotation;
    #[ORM\OneToMany(targetEntity: AvisPaquet::class, mappedBy: 'dossier')]
    private $avisPaquets;

    #[ORM\OneToMany(mappedBy: 'dossier', targetEntity: DeliberationDossiers::class)]
    private $deliberation;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'dossiersRequerant')]
    private ?Partie $requerant;
    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'dossiersDefendeur')]
    private ?Partie $defendeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $arreteAttaquee = null;

    #[ORM\ManyToOne(inversedBy: 'dossiers')]
    private ?User $createdBy = null;

    #[ORM\Column(nullable: true)]
    private ?bool $consignation = false;

    #[ORM\Column(nullable: true)]
    private ?bool $memoireAmpliatif = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMemoireAmpliatif = null;

    #[ORM\Column(nullable: true)]
    private ?bool $memoireEnDefense = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMemoireEnDefense = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateConsignation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preuveConsignation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlMemoireAmpliatif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlMemoireEnDefense = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeSuivi = null;

    #[ORM\Column(nullable: true)]
    private ?bool $externe = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateAutorisation;

    /**
     * @var Collection<int, Mouvement>
     */
    #[ORM\OneToMany(mappedBy: 'Dossier', targetEntity: Mouvement::class)]
    private Collection $mouvements;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    /**
     * @var Collection<int, AffecterUser>
     */
    #[ORM\OneToMany(mappedBy: 'dossier', targetEntity: AffecterUser::class)]
    private Collection $affecterUsers;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $calendrier = null;

    #[ORM\OneToOne(targetEntity: Rapport::class, mappedBy: "dossier")]
    private $rapport;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rapportCR = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observationDescriptionRequerante = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observationFichierRequerante = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observationDescriptionDefendeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observationFichierDefendeur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $rapportDescriptionCR = null;

    #[ORM\Column(nullable: true)]
    private ?bool $finMesuresInstruction = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finMesuresInstructionAt = null;

    /**
     * @var Collection<int, Pieces>
     */
    #[ORM\OneToMany(mappedBy: 'dossier', targetEntity: Pieces::class)]
    private Collection $piecesDoc;

    #[ORM\OneToOne(mappedBy: 'dossier', cascade: ['persist', 'remove'])]
    private ?PaiementConsignation $paiementConsignation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PreuveConsignationRequerant = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DatePreuveConsignationRequerant = null;

    #[ORM\Column(nullable: true)]
    private ?bool $RecuConsignation = null;

    public function __construct()
    {
        $this->userDossiers = new ArrayCollection();
        $this->structures = new ArrayCollection();

        $this->arrets = new ArrayCollection();

        $this->pieces = new ArrayCollection();
        $this->audience = new ArrayCollection();
        $this->mesuresInstructions = new ArrayCollection();
        $this->avisPaquets = new ArrayCollection();
        $this->deliberation = new ArrayCollection();
        $this->mouvements = new ArrayCollection();
        $this->affecterUsers = new ArrayCollection();
        $this->piecesDoc = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getReferenceEnregistrement(): ?string
    {
        return $this->referenceEnregistrement;
    }

    public function setReferenceEnregistrement(string $referenceEnregistrement): self
    {
        $this->referenceEnregistrement = $referenceEnregistrement;

        return $this;
    }

    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(?Rapport $rapport): self
    {
        // Définissez la relation bidirectionnelle
        if ($rapport !== null && $rapport->getDossier() !== $this) {
            $rapport->setDossier($this);
        }

        $this->rapport = $rapport;
        return $this;
    }


    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->dateEnregistrement;
    }

    public function setDateEnregistrement(?\DateTimeInterface $dateEnregistrement): self
    {
        $this->dateEnregistrement = $dateEnregistrement;

        return $this;
    }

    public function getDateAutorisation(): ?\DateTimeInterface
    {
        return $this->dateAutorisation;
    }

    public function setDateAutorisation(?\DateTimeInterface $dateAutorisation): self
    {
        $this->dateAutorisation = $dateAutorisation;

        return $this;
    }

    public function getTypeDossier(): ?string
    {
        return $this->typeDossier;
    }

    public function setTypeDossier(?string $typeDossier): self
    {
        $this->typeDossier = $typeDossier;

        return $this;
    }

    public function getReferenceDossier(): ?string
    {
        return $this->referenceDossier;
    }

    public function setReferenceDossier(?string $referenceDossier): self
    {
        $this->referenceDossier = $referenceDossier;

        return $this;
    }

    public function getIntituleObjet(): ?string
    {
        return $this->intituleObjet;
    }

    public function setIntituleObjet(?string $intituleObjet): self
    {
        $this->intituleObjet = $intituleObjet;

        return $this;
    }

    public function getReferenceDossierComplet(): ?string
    {
        return $this->referenceDossierComplet;
    }

    public function setReferenceDossierComplet(?string $referenceDossierComplet): self
    {
        $this->referenceDossierComplet = $referenceDossierComplet;

        return $this;
    }

    public function getEtatDossier(): ?string
    {
        return $this->etatDossier;
    }

    public function setEtatDossier(?string $etatDossier): self
    {
        $this->etatDossier = $etatDossier;

        return $this;
    }

    public function getObjet(): ?Objet
    {
        return $this->objet;
    }

    public function setObjet(?Objet $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * @return Collection<int, UserDossier>
     */
    public function getUserDossiers(): Collection
    {
        return $this->userDossiers;
    }

    public function addUserDossier(UserDossier $userDossier): self
    {
        if (!$this->userDossiers->contains($userDossier)) {
            $this->userDossiers[] = $userDossier;
            $userDossier->setDossier($this);
        }

        return $this;
    }

    public function removeUserDossier(UserDossier $userDossier): self
    {
        if ($this->userDossiers->removeElement($userDossier)) {
            // set the owning side to null (unless already changed)
            if ($userDossier->getDossier() === $this) {
                $userDossier->setDossier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AffecterStructure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(AffecterStructure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures[] = $structure;
            $structure->setDossier($this);
        }

        return $this;
    }

    public function removeStructure(AffecterStructure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getDossier() === $this) {
                $structure->setDossier(null);
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
            $arret->setDossier($this);
        }

        return $this;
    }

    public function removeArret(Arrets $arret): self
    {
        if ($this->arrets->removeElement($arret)) {
            // set the owning side to null (unless already changed)
            if ($arret->getDossier() === $this) {
                $arret->setDossier(null);
            }
        }

        return $this;
    }


    public function getRequerant(): ?Partie
    {
        return $this->requerant;
    }

    public function setRequerant(?Partie $requerant): self
    {
        $this->requerant = $requerant;

        return $this;
    }


    /**
     * @return Collection<int, DossierPiecesJointes>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(DossierPiecesJointes $piece): self
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces[] = $piece;
            $piece->setDossier($this);
        }

        return $this;
    }

    public function removePiece(DossierPiecesJointes $piece): self
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getDossier() === $this) {
                $piece->setDossier(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(?\DateTimeInterface $dateOuverture): self
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    /**
     * @return Collection<int, Audience>
     */
    public function getAudience(): Collection
    {
        return $this->audience;
    }

    public function addAudience(Audience $audience): self
    {
        if (!$this->audience->contains($audience)) {
            $this->audience[] = $audience;
        }

        return $this;
    }

    public function removeAudience(Audience $audience): self
    {
        $this->audience->removeElement($audience);

        return $this;
    }

    public function __toString()
    {
        return $this->intituleObjet;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getProvenance(): ?Provenance
    {
        return $this->provenance;
    }

    public function setProvenance(?Provenance $provenance): self
    {
        $this->provenance = $provenance;

        return $this;
    }

    public function isAutorisation(): ?bool
    {
        return $this->autorisation;
    }

    public function setAutorisation(?bool $autorisation): self
    {
        $this->autorisation = $autorisation;

        return $this;
    }

    /**
     * @return Collection<int, MesuresInstructions>
     */
    public function getMesuresInstructions(): Collection
    {
        return $this->mesuresInstructions;
    }

    public function addMesuresInstruction(MesuresInstructions $mesuresInstruction): self
    {
        if (!$this->mesuresInstructions->contains($mesuresInstruction)) {
            $this->mesuresInstructions[] = $mesuresInstruction;
            $mesuresInstruction->setDossier($this);
        }

        return $this;
    }

    public function removeMesuresInstruction(MesuresInstructions $mesuresInstruction): self
    {
        if ($this->mesuresInstructions->removeElement($mesuresInstruction)) {
            // set the owning side to null (unless already changed)
            if ($mesuresInstruction->getDossier() === $this) {
                $mesuresInstruction->setDossier(null);
            }
        }

        return $this;
    }

    public function getAffecterSection(): ?AffecterSection
    {
        return $this->affecterSection;
    }

    public function setAffecterSection(?AffecterSection $affecterSection): self
    {
        // unset the owning side of the relation if necessary
        if ($affecterSection === null && $this->affecterSection !== null) {
            $this->affecterSection->setDossier(null);
        }

        // set the owning side of the relation if necessary
        if ($affecterSection !== null && $affecterSection->getDossier() !== $this) {
            $affecterSection->setDossier($this);
        }

        $this->affecterSection = $affecterSection;

        return $this;
    }

    public function isClos(): ?bool
    {
        return $this->clos;
    }

    public function setClos(?bool $clos): self
    {
        $this->clos = $clos;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(?\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    public function getMotifCloture(): ?string
    {
        return $this->motifCloture;
    }

    public function setMotifCloture(?string $motifCloture): self
    {
        $this->motifCloture = $motifCloture;

        return $this;
    }


    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(?string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * @return Collection<int, AvisPaquet>
     */
    public function getAvisPaquets(): Collection
    {
        return $this->avisPaquets;
    }

    public function addAvisPaquet(AvisPaquet $avisPaquet): self
    {
        if (!$this->avisPaquets->contains($avisPaquet)) {
            $this->avisPaquets[] = $avisPaquet;
            $avisPaquet->setDossier($this);
        }

        return $this;
    }

    public function removeAvisPaquet(AvisPaquet $avisPaquet): self
    {
        if ($this->avisPaquets->removeElement($avisPaquet)) {
            // set the owning side to null (unless already changed)
            if ($avisPaquet->getDossier() === $this) {
                $avisPaquet->setDossier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DeliberationDossiers>
     */
    public function getDeliberation(): Collection
    {
        return $this->deliberation;
    }

    public function addDeliberation(DeliberationDossiers $deliberation): self
    {
        if (!$this->deliberation->contains($deliberation)) {
            $this->deliberation[] = $deliberation;
            $deliberation->setDossier($this);
        }

        return $this;
    }

    public function removeDeliberation(DeliberationDossiers $deliberation): self
    {
        if ($this->deliberation->removeElement($deliberation)) {
            // set the owning side to null (unless already changed)
            if ($deliberation->getDossier() === $this) {
                $deliberation->setDossier(null);
            }
        }

        return $this;
    }

    public function getDefendeur(): ?Partie
    {
        return $this->defendeur;
    }

    public function setDefendeur(?Partie $defendeur): static
    {
        $this->defendeur = $defendeur;

        return $this;
    }

    public function getArreteAttaquee(): ?string
    {
        return $this->arreteAttaquee;
    }

    public function setArreteAttaquee(?string $arreteAttaquee): static
    {
        $this->arreteAttaquee = $arreteAttaquee;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function isConsignation(): ?bool
    {
        return $this->consignation;
    }

    public function setConsignation(?bool $consignation): static
    {
        $this->consignation = $consignation;

        return $this;
    }

    public function isMemoireAmpliatif(): ?bool
    {
        return $this->memoireAmpliatif;
    }

    public function setMemoireAmpliatif(?bool $memoireAmpliatif): static
    {
        $this->memoireAmpliatif = $memoireAmpliatif;

        return $this;
    }

    public function getDateMemoireAmpliatif(): ?\DateTimeInterface
    {
        return $this->dateMemoireAmpliatif;
    }

    public function setDateMemoireAmpliatif(?\DateTimeInterface $dateMemoireAmpliatif): static
    {
        $this->dateMemoireAmpliatif = $dateMemoireAmpliatif;

        return $this;
    }

    public function isMemoireEnDefense(): ?bool
    {
        return $this->memoireEnDefense;
    }

    public function setMemoireEnDefense(?bool $memoireEnDefense): static
    {
        $this->memoireEnDefense = $memoireEnDefense;

        return $this;
    }

    public function getDateMemoireEnDefense(): ?\DateTimeInterface
    {
        return $this->dateMemoireEnDefense;
    }

    public function setDateMemoireEnDefense(?\DateTimeInterface $dateMemoireEnDefense): static
    {
        $this->dateMemoireEnDefense = $dateMemoireEnDefense;

        return $this;
    }

    public function getDateConsignation(): ?\DateTimeInterface
    {
        return $this->dateConsignation;
    }

    public function setDateConsignation(?\DateTimeInterface $dateConsignation): static
    {
        $this->dateConsignation = $dateConsignation;

        return $this;
    }

    public function getPreuveConsignation(): ?string
    {
        return $this->preuveConsignation;
    }

    public function setPreuveConsignation(?string $preuveConsignation): static
    {
        $this->preuveConsignation = $preuveConsignation;

        return $this;
    }

    public function getUrlMemoireAmpliatif(): ?string
    {
        return $this->urlMemoireAmpliatif;
    }

    public function setUrlMemoireAmpliatif(?string $urlMemoireAmpliatif): static
    {
        $this->urlMemoireAmpliatif = $urlMemoireAmpliatif;

        return $this;
    }

    public function getUrlMemoireEnDefense(): ?string
    {
        return $this->urlMemoireEnDefense;
    }

    public function setUrlMemoireEnDefense(?string $urlMemoireEnDefense): static
    {
        $this->urlMemoireEnDefense = $urlMemoireEnDefense;

        return $this;
    }

    public function getCodeSuivi(): ?string
    {
        return $this->codeSuivi;
    }

    public function setCodeSuivi(?string $codeSuivi): static
    {
        $this->codeSuivi = $codeSuivi;

        return $this;
    }

    public function isExterne(): ?bool
    {
        return $this->externe;
    }

    public function setExterne(?bool $externe): static
    {
        $this->externe = $externe;

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
            $mouvement->setDossier($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): static
    {
        if ($this->mouvements->removeElement($mouvement)) {
            // set the owning side to null (unless already changed)
            if ($mouvement->getDossier() === $this) {
                $mouvement->setDossier(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
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
            $affecterUser->setDossier($this);
        }

        return $this;
    }

    public function removeAffecterUser(AffecterUser $affecterUser): static
    {
        if ($this->affecterUsers->removeElement($affecterUser)) {
            // set the owning side to null (unless already changed)
            if ($affecterUser->getDossier() === $this) {
                $affecterUser->setDossier(null);
            }
        }

        return $this;
    }

    public function getCalendrier(): ?string
    {
        return $this->calendrier;
    }

    public function setCalendrier(?string $calendrier): static
    {
        $this->calendrier = $calendrier;

        return $this;
    }

    public function getIntitule()
    {
      $intitule = '';
        if ($this->requerant->getType() =='moral'){
            $intitule = $this->requerant->getIntitule();
        } else{
            $intitule = $this->requerant->getNom() .' '. $this->requerant->getPrenoms();
        }

        if ($this->defendeur->getType() =='moral'){
            $intitule .= ' contre '.$this->defendeur->getIntitule();
        } else{
            $intitule .= ' contre '. $this->defendeur->getNom() .' '. $this->defendeur->getPrenoms();
        }
        if ($this->referenceDossier){
            $intitule .= ' ( '.$this->referenceDossier.')';
        }
        return $intitule;
    }

    public function getPathCalendrier(): ?string
    {
        return 'https://' . $_SERVER['SERVER_NAME']. '/uploads/calendrier/' . $this->calendrier;

    }

    public function getRapportCR(): ?string
    {
        return $this->rapportCR;
    }

    public function getRapportCRFichier(): ?string
    {
        return 'https://' . $_SERVER['SERVER_NAME']. '/uploads/piecesJointes/' . $this->rapportCR;
    }

    public function setRapportCR(?string $rapportCR): static
    {
        $this->rapportCR = $rapportCR;

        return $this;
    }

    public function getObservationDescriptionRequerante(): ?string
    {
        return $this->observationDescriptionRequerante;
    }

    public function setObservationDescriptionRequerante(?string $observationDescriptionRequerante): static
    {
        $this->observationDescriptionRequerante = $observationDescriptionRequerante;

        return $this;
    }

    public function getObservationFichierRequerante(): ?string
    {
        return $this->observationFichierRequerante;
    }

    public function setObservationFichierRequerante(?string $observationFichierRequerante): static
    {
        $this->observationFichierRequerante = $observationFichierRequerante;

        return $this;
    }

    public function getObservationDescriptionDefendeur(): ?string
    {
        return $this->observationDescriptionDefendeur;
    }

    public function setObservationDescriptionDefendeur(?string $observationDescriptionDefendeur): static
    {
        $this->observationDescriptionDefendeur = $observationDescriptionDefendeur;

        return $this;
    }

    public function getObservationFichierDefendeur(): ?string
    {
        return $this->observationFichierDefendeur;
    }

    public function setObservationFichierDefendeur(?string $observationFichierDefendeur): static
    {
        $this->observationFichierDefendeur = $observationFichierDefendeur;

        return $this;
    }

    public function getRapportDescriptionCR(): ?string
    {
        return $this->rapportDescriptionCR;
    }

    public function setRapportDescriptionCR(?string $rapportDescriptionCR): static
    {
        $this->rapportDescriptionCR = $rapportDescriptionCR;

        return $this;
    }

    public function isFinMesuresInstruction(): ?bool
    {
        return $this->finMesuresInstruction;
    }

    public function setFinMesuresInstruction(?bool $finMesuresInstruction): static
    {
        $this->finMesuresInstruction = $finMesuresInstruction;

        return $this;
    }

    public function getFinMesuresInstructionAt(): ?\DateTimeInterface
    {
        return $this->finMesuresInstructionAt;
    }

    public function setFinMesuresInstructionAt(?\DateTimeInterface $finMesuresInstructionAt): static
    {
        $this->finMesuresInstructionAt = $finMesuresInstructionAt;

        return $this;
    }

    /**
     * @return Collection<int, Pieces>
     */
    public function getPiecesDoc(): Collection
    {
        return $this->piecesDoc;
    }

    public function addPiecesDoc(Pieces $piecesDoc): static
    {
        if (!$this->piecesDoc->contains($piecesDoc)) {
            $this->piecesDoc->add($piecesDoc);
            $piecesDoc->setDossier($this);
        }

        return $this;
    }

    public function removePiecesDoc(Pieces $piecesDoc): static
    {
        if ($this->piecesDoc->removeElement($piecesDoc)) {
            // set the owning side to null (unless already changed)
            if ($piecesDoc->getDossier() === $this) {
                $piecesDoc->setDossier(null);
            }
        }

        return $this;
    }

    public function getPaiementConsignation(): ?PaiementConsignation
    {
        return $this->paiementConsignation;
    }

    public function setPaiementConsignation(PaiementConsignation $paiementConsignation): static
    {
        // set the owning side of the relation if necessary
        if ($paiementConsignation->getDossier() !== $this) {
            $paiementConsignation->setDossier($this);
        }

        $this->paiementConsignation = $paiementConsignation;

        return $this;
    }

    public function getPreuveConsignationRequerant(): ?string
    {
        return $this->PreuveConsignationRequerant;
    }

    public function setPreuveConsignationRequerant(?string $PreuveConsignationRequerant): static
    {
        $this->PreuveConsignationRequerant = $PreuveConsignationRequerant;

        return $this;
    }

    public function getDatePreuveConsignationRequerant(): ?\DateTimeImmutable
    {
        return $this->DatePreuveConsignationRequerant;
    }

    public function setDatePreuveConsignationRequerant(?\DateTimeImmutable $DatePreuveConsignationRequerant): static
    {
        $this->DatePreuveConsignationRequerant = $DatePreuveConsignationRequerant;

        return $this;
    }

    public function isRecuConsignation(): ?bool
    {
        return $this->RecuConsignation;
    }

    public function setRecuConsignation(?bool $RecuConsignation): static
    {
        $this->RecuConsignation = $RecuConsignation;

        return $this;
    }
    
}



