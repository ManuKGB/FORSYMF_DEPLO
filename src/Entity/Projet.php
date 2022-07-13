<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['getprojet'])]
    private $id;

    #[ORM\Column(type: 'date')]
    #[Groups(['getprojet'])]
    private $dateDebutProj;

    #[ORM\Column(type: 'date')]
    #[Groups(['getprojet'])]
    private $dateFinEstimeProj;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['getprojet'])]
    private $dateFinProj;

    #[ORM\Column(type: 'integer')]
    #[Groups(['getprojet'])]
    private $montantInitialProj;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['getprojet'])]
    private $montantProj;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['getprojet'])]
    private $dateApprove;

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
}
