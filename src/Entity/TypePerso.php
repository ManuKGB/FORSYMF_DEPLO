<?php

namespace App\Entity;

use App\Repository\TypePersoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePersoRepository::class)]
class TypePerso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le libelle est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le libelle doit faire au moins {{ limit }} caractères", maxMessage: "Le libelle ne peut pas faire plus de {{ limit }} caractères")]
    private $libelle;

    #[ORM\Column(type: 'string', length: 300, nullable: true)]
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
