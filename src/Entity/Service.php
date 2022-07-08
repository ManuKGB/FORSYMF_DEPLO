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
    #[Groups(["getServ"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getServ"])]
    private $LibelleService;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getServ"])]
    private $Description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    #[Groups(["getServ"])]
    private $Montant;

    #[ORM\Column(type: 'date')]
    #[Groups(["getServ"])]
    private $DateFinServ;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["getServ"])]
    private $Deleted;

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleService(): ?string
    {
        return $this->LibelleService;
    }

    public function setLibelleService(string $LibelleService): self
    {
        $this->LibelleService = $LibelleService;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->Montant;
    }

    public function setMontant(string $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getDateFinServ(): ?\DateTimeInterface
    {
        return $this->DateFinServ;
    }

    public function setDateFinServ(\DateTimeInterface $DateFinServ): self
    {
        $this->DateFinServ = $DateFinServ;

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
