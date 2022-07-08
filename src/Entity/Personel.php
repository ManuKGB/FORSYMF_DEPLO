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

#[ORM\Entity(repositoryClass: PersonelRepository::class)]
class Personel implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    
    #[Groups(['personel:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
        
    #[Groups(['personel:read'])]
    private $nom;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
        
    #[Groups(['personel:read'])]
    private $prenom;

    #[ORM\Column(type: 'date')]
        
    #[Groups(['personel:read'])]
    private $date_naissance;

    #[ORM\Column(type: 'string', length: 255)]
        
    #[Groups(['personel:read'])]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
        
    #[Groups(['personel:read'])]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
        
    #[Groups(['personel:read'])]
    private $contact;

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
}
