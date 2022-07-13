<?php
namespace App\Entity;
use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["getServ","get"])]  
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getServ","get"])]
    private $libelleService;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getServ","get"])]
    private $description;

    #[ORM\Column(type: 'integer')]
    #[Groups(["getServ","get"])]
    private $montant;

    #[ORM\Column(type: 'date')]
    #[Groups(["getServ","get"])]
    private $dateFinServ;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["getServ","get"])]
    private $deleted;

    #[ORM\ManyToOne(targetEntity: Prestataire::class, inversedBy: 'services')]
    #[Groups(["getServ"])]
    private $prestataire;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleService(): ?string
    {
        return $this->libelleService;
    }

    public function setLibelleService(string $LibelleService): self
    {
        $this->libelleService = $LibelleService;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $Description): self
    {
        $this->description = $Description;

        return $this;
    }

    public function getMontant():?int
    {
        return $this->montant;
    }

    public function setMontant(int $Montant): self
    {
        $this->montant = $Montant;

        return $this;
    }

    public function getDateFinServ(): ?\DateTimeInterface
    {
        return $this->dateFinServ;
    }

    public function setDateFinServ(\DateTimeInterface $DateFinServ): self
    {
        $this->dateFinServ = $DateFinServ;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $Deleted): self
    {
        $this->deleted = $Deleted;

        return $this;
    }

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): self
    {
        $this->prestataire = $prestataire;

        return $this;
    }
}
