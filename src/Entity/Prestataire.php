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
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getPrest"])]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["getPrest"])]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["getPrest"])]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["getPrest"])]
    private $raisonSocial;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getPrest"])]
    private $poste;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["getPrest"])]
    private $actif;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["getPrest"])]
    private $deleted;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raisonSocial;
    }

    public function setRaisonSocial(?string $raisonSocial): self
    {
        $this->raisonSocial = $raisonSocial;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $Poste): self
    {
        $this->poste = $Poste;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

   

   
}
