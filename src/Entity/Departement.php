<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["getPersonel","get2"])]

    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le libelle est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le libelle doit faire au moins {{ limit }} caractères", maxMessage: "Le libelle ne peut pas faire plus de {{ limit }} caractères")]

    #[Groups(["getPersonel","get2"])]

    private $libelle;

    #[ORM\Column(type: 'string', length: 400, nullable: true)]

    #[Groups(["getPersonel","get2"])]

    private $description;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Personel::class)]
    

    #[Groups(["get2","get3"])]
    private $personel;

    #[ORM\Column]
    #[Groups(["getPersonel","get2"])]
    private ?bool $deleted = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Personel $chef = null;

    public function __construct()
    {
        $this->personel = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Personel>
     */
    public function getPersonel(): Collection
    {
        return $this->personel;
    }

    public function addPersonel(Personel $personel): self
    {
        if (!$this->personel->contains($personel)) {
            $this->personel[] = $personel;
            $personel->setDepartement($this);
        }

        return $this;
    }

    public function removePersonel(Personel $personel): self
    {
        if ($this->personel->removeElement($personel)) {
            // set the owning side to null (unless already changed)
            if ($personel->getDepartement() === $this) {
                $personel->setDepartement(null);
            }
        }

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

    public function getChef(): ?Personel
    {
        return $this->chef;
    }

    public function setChef(?Personel $chef): self
    {
        $this->chef = $chef;

        return $this;
    }
}
