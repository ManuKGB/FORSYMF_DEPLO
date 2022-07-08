<?php

namespace App\Entity;

use App\Repository\PrestataireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PrestataireRepository::class)]
class Prestataire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["getPrest"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getPrest"])]
    private $Nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getPrest"])]
    private $Prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["getPrest"])]
    private $Email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["getPrest"])]
    private $Adresse;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["getPrest"])]
    private $RaisonSocial;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getPrest"])]
    private $Poste;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["getPrest"])]
    private $Actif;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["getPrest"])]
    private $Deleted;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(?string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->RaisonSocial;
    }

    public function setRaisonSocial(?string $RaisonSocial): self
    {
        $this->RaisonSocial = $RaisonSocial;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->Poste;
    }

    public function setPoste(string $Poste): self
    {
        $this->Poste = $Poste;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->Actif;
    }

    public function setActif(bool $Actif): self
    {
        $this->Actif = $Actif;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->Deleted;
    }

    public function setDeleted(bool $Deleted): self
    {
        $this->Deleted = $Deleted;

        return $this;
    }

   

   
}
