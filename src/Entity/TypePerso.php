<?php

namespace App\Entity;

use App\Repository\TypePersoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypePersoRepository::class)]
class TypePerso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    
    #[Groups(["getPersonel","get2","get4","get6"])]

    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le libelle est obligatoire")]
    #[Groups(["getPersonel","get2","get4","get6"])]
    private $libelle;

    #[ORM\Column(type: 'string', length: 300, nullable: true)]
    #[Groups(["getPersonel","get2","get4","get6"])]
    private $description;

    #[ORM\OneToMany(mappedBy: 'typePerso', targetEntity: Personel::class)]
    #[Groups(["get4"])]

    
    private $Personel;

    #[ORM\Column]
    #[Groups(["getPersonel","get2","get4","get6"])]
    private ?bool $deleted = null;

    public function __construct()
    {
        $this->Personel = new ArrayCollection();
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
        return $this->Personel;
    }

    public function addPersonel(Personel $personel): self
    {
        if (!$this->Personel->contains($personel)) {
            $this->Personel[] = $personel;
            $personel->setTypePerso($this);
        }

        return $this;
    }

    public function removePersonel(Personel $personel): self
    {
        if ($this->Personel->removeElement($personel)) {
            // set the owning side to null (unless already changed)
            if ($personel->getTypePerso() === $this) {
                $personel->setTypePerso(null);
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
}
