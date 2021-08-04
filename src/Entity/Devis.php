<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="devis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicule::class, inversedBy="devis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicule;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRetour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $agenceDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $agenceRetour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuSejour;

    /**
     * @ORM\Column(type="boolean")
     */
    private $conducteur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="float")
     */
    private $duree;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Options::class, inversedBy="devis")
     */
    private $siege;

    /**
     * @ORM\ManyToOne(targetEntity=Garantie::class, inversedBy="devis")
     */
    private $garantie;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $transformed;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tarifVehicule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getVehicule(): ?vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeInterface $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getAgenceDepart(): ?string
    {
        return $this->agenceDepart;
    }

    public function setAgenceDepart(string $agenceDepart): self
    {
        $this->agenceDepart = $agenceDepart;

        return $this;
    }

    public function getAgenceRetour(): ?string
    {
        return $this->agenceRetour;
    }

    public function setAgenceRetour(string $agenceRetour): self
    {
        $this->agenceRetour = $agenceRetour;

        return $this;
    }

    public function getLieuSejour(): ?string
    {
        return $this->lieuSejour;
    }

    public function setLieuSejour(string $lieuSejour): self
    {
        $this->lieuSejour = $lieuSejour;

        return $this;
    }

    public function getConducteur(): ?bool
    {
        return $this->conducteur;
    }

    public function setConducteur(bool $conducteur): self
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getSiege(): ?Options
    {
        return $this->siege;
    }

    public function setSiege(?Options $siege): self
    {
        $this->siege = $siege;

        return $this;
    }

    public function getGarantie(): ?Garantie
    {
        return $this->garantie;
    }

    public function setGarantie(?Garantie $garantie): self
    {
        $this->garantie = $garantie;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function setNumeroDevis($currentID)
    {
        if ($currentID < 10) {
            $currentID = '0000' . $currentID;
        }
        if ($currentID < 100 && $currentID > 10) {
            $currentID = '000' . $currentID;
        }
        if ($currentID < 1000 && $currentID > 100) {
            $currentID = '00' . $currentID;
        }
        if ($currentID < 10000 && $currentID > 1000) {
            $currentID = '0' . $currentID;
        }
        $ref  = "DV" . $currentID;
        $this->setNumero($ref);
    }

    public function getTransformed(): ?bool
    {
        return $this->transformed;
    }

    public function setTransformed(?bool $transformed): self
    {
        $this->transformed = $transformed;

        return $this;
    }

    public function getTarifVehicule(): ?float
    {
        return $this->tarifVehicule;
    }

    public function setTarifVehicule(?float $tarifVehicule): self
    {
        $this->tarifVehicule = $tarifVehicule;

        return $this;
    }
}
