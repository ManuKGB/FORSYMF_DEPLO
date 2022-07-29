<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['getprojet','gettaches'])]

    private $id;

    #[ORM\Column(type: 'date')]
    #[Groups(['getprojet','gettaches'])]
    #[Assert\NotBlank(message: "La saisie de la date de début est importante.")]
    private $dateDebutProj;

    #[ORM\Column(type: 'date')]
    #[Groups(['getprojet','gettaches'])]
    #[Assert\NotBlank(message: "La saisie de la date de fin estimée est importante.")]
    private $dateFinEstimeProj;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['getprojet','gettaches'])]
    
    private $dateFinProj;

    #[ORM\Column(type: 'integer')]
    #[Groups(['getprojet','gettaches'])]
    #[Assert\NotBlank(message: "La saisie du du montant initialement fixé est importante.")]
    private $montantInitialProj;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['getprojet','gettaches'])]
    private $montantProj;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['getprojet','gettaches'])]

    private $dateApprove;

    #[ORM\Column]
    #[Groups(['getprojet','gettaches'])]
    private ?bool $actif = null;



    #[ORM\Column(length: 255)]
    #[Groups(['getprojet','gettaches'])]

    private ?string $titre = null;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Taches::class)]
    #[Groups(['getprojet'])]

    private Collection $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

   
    

   




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutProj(): ?\DateTimeInterface
    {
        return $this->dateDebutProj;
    }

    public function setDateDebutProj(\DateTimeInterface $dateDebutProj): self
    {
        $this->dateDebutProj = $dateDebutProj;

        return $this;
    }

    public function getDateFinEstimeProj(): ?\DateTimeInterface
    {
        return $this->dateFinEstimeProj;
    }

    public function setDateFinEstimeProj(\DateTimeInterface $dateFinEstimeProj): self
    {
        $this->dateFinEstimeProj = $dateFinEstimeProj;

        return $this;
    }

    public function getDateFinProj(): ?\DateTimeInterface
    {
        return $this->dateFinProj;
    }

    public function setDateFinProj(?\DateTimeInterface $dateFinProj): self
    {
        $this->dateFinProj = $dateFinProj;

        return $this;
    }

    public function getMontantInitialProj(): ?int
    {
        return $this->montantInitialProj;
    }

    public function setMontantInitialProj(int $montantInitialProj): self
    {
        $this->montantInitialProj = $montantInitialProj;

        return $this;
    }

    public function getMontantProj(): ?int
    {
        return $this->montantProj;
    }

    public function setMontantProj(?int $montantProj): self
    {
        $this->montantProj = $montantProj;

        return $this;
    }

    public function getDateApprove(): ?\DateTimeInterface
    {
        return $this->dateApprove;
    }

    public function setDateApprove(?\DateTimeInterface $dateApprove): self
    {
        $this->dateApprove = $dateApprove;

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



    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection<int, Taches>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Taches $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setProjet($this);
        }

        return $this;
    }

    public function removeTach(Taches $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getProjet() === $this) {
                $tach->setProjet(null);
            }
        }

        return $this;
    }

   

 
}
