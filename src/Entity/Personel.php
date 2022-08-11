<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\PersonelRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\personel\PasswordAuthenticatedpersonelInterface;
use Symfony\Component\Security\Core\personel\personelInterface;
// use Webmozart\Assert\Assert;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: PersonelRepository::class)]
class Personel implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["getPersonel", "gettaches"])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
        
    #[Groups(["getPersonel", "gettaches"])]
    private $nom;

    #[ORM\Column(type: 'json')]
    #[Groups(["getPersonel", "gettaches"])]
    private $roles = [];

    #[ORM\Column(type: 'string',nullable: true)]
    #[Groups(["getPersonel", "gettaches"])]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le prenom est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le prenom doit faire au moins {{ limit }} caractères", maxMessage: "Le prenom ne peut pas faire plus de {{ limit }} caractères")]
    #[Groups(["getPersonel", "gettaches"])]
    private $prenom;

    #[ORM\Column(type: 'date',nullable: true)]
    #[Groups(["getPersonel", "gettaches"])]
    private $date_naissance;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "L'adresse est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "L'adresse doit faire au moins {{ limit }} caractères", maxMessage: "L'adresse ne peut pas faire plus de {{ limit }} caractères")] 
    #[Groups(["getPersonel", "gettaches"])]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "L'email est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "L'email doit faire au moins {{ limit }} caractères", maxMessage: "L'email ne peut pas faire plus de {{ limit }} caractères")]
    #[Groups(["getPersonel", "gettaches"])]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le contact est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le contact doit faire au moins {{ limit }} caractères", maxMessage: "Le contact ne peut pas faire plus de {{ limit }} caractères")]
    #[Groups(["getPersonel", "gettaches"])]
    private $contact;

    #[ORM\ManyToOne(targetEntity: Departement::class, inversedBy: 'personel')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getPersonel", "gettaches"])]
   
    private $departement;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'chef')]
    #[ORM\JoinColumn(nullable: true)]
 
    private $personel;

    #[ORM\OneToMany(mappedBy: 'personel', targetEntity: self::class)]
    #[Groups(["getPersonel", "gettaches"])]
    private $chef;
    
    #[ORM\ManyToOne(targetEntity: TypePerso::class, inversedBy: 'Personel')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getPersonel", "gettaches"])]
    
    private $typePerso;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["getPersonel", "gettaches"])]
    private $username;

    #[ORM\Column]
    #[Groups(["getPersonel", "gettaches"])]
    private ?bool $deleted = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ischef = null;

    #[ORM\ManyToMany(targetEntity: Taches::class, mappedBy: 'attribuer')]
    #[Groups([ "gettaches"])]
    private Collection $taches;

    public function __construct()
    {
        $this->chef = new ArrayCollection();
        $this->taches = new ArrayCollection();
    }

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

    /**
     * A visual identifier that represents this personel.
     *
     * @see personelInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see personelInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every personel at least has ROLE_personel
       // $roles[] = 'ROLE_personel';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedpersonelInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see personelInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the personel, clear it here
        // $this->plainPassword = null;
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
        
    }

    public function setDateNaissance( \DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
    /**
     * Méthode getpersonelname qui permet de retourner le champ qui est utilisé pour l'authentification.
     *
     * @return string
     */
    public function getpersonelname(): string {
        return $this->getUserIdentifier();
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getPersonel(): ?self
    {
        return $this->personel;
    }

    public function setPersonel(?self $personel): self
    {
        $this->personel = $personel;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChef(): Collection
    {
        return $this->chef;
    }

    public function addChef(self $chef): self
    {
        if (!$this->chef->contains($chef)) {
            $this->chef[] = $chef;
            $chef->setPersonel($this);
        }

        return $this;
    }

    public function removeChef(self $chef): self
    {
        if ($this->chef->removeElement($chef)) {
            // set the owning side to null (unless already changed)
            if ($chef->getPersonel() === $this) {
                $chef->setPersonel(null);
            }
        }

        return $this;
    }

    public function getTypePerso(): ?TypePerso
    {
        return $this->typePerso;
    }

    public function setTypePerso(?TypePerso $typePerso): self
    {
        $this->typePerso = $typePerso;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

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

    public function isIschef(): ?bool
    {
        return $this->ischef;
    }

    public function setIschef(?bool $ischef): self
    {
        $this->ischef = $ischef;

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
            $tach->addAttribuer($this);
        }

        return $this;
    }

    public function removeTach(Taches $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            $tach->removeAttribuer($this);
        }

        return $this;
    }
}
