<?php

namespace App\Entity;

use App\Repository\TachesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TachesRepository::class)]
class Taches  
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['gettaches','getprojet',"getPersonel"])]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['gettaches','getprojet'])]
    #[Assert\NotBlank(message: "La saisi du résumé de la tâche est importante.")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le titre doit faire au moins {{ limit }} caractères", maxMessage: "Le titre ne peut pas faire plus de {{ limit }} caractères")]
    private $resume;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['gettaches','getprojet',"getPersonel"])]
    private $priorite;

    #[ORM\Column(type: 'date')]
    #[Groups(['gettaches','getprojet',"getPersonel"])]
     #[Assert\NotBlank(message: "La date de début est importante.")]
    private $dateDebutProjet;

    #[ORM\Column(type: 'date')]
    #[Groups(['gettaches','getprojet',"getPersonel"])]
    #[Assert\NotBlank(message: "vous devez saisie la sate de la fin du projet (date que vous avez estimé)")]
    private $dateFinEstimeProj;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['gettaches','getprojet',"getPersonel"])]
    private $motifRetard;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['gettaches','getprojet',"getPersonel"])]

    private $dateDerniereMiseAJour;

    #[ORM\Column]
    #[Groups(['gettaches','getprojet',"getPersonel"])]
    private ?bool $actif = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[Groups(['gettaches'])]

    private ?Projet $projet = null;

    #[ORM\OneToMany(mappedBy: 'tache', targetEntity: Notification::class)]
    private Collection $notifications;

    #[ORM\ManyToMany(targetEntity: Personel::class, inversedBy: 'taches')]
    #[Groups(["getprojet"])]
    private Collection $attribuer;

    

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
        $this->attribuer = new ArrayCollection();
    }
    public function addtachePersonnel(Personel $personel)
    {
        if ($this->attribuer->contains($personel)){
            return;
        }
        $this ->attribuer[] = $personel;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
 

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(?string $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getDateDebutProjet(): ?\DateTimeInterface
    {
        return $this->dateDebutProjet;
    }

    public function setDateDebutProjet(\DateTimeInterface $dateDebutProjet): self
    {
        $this->dateDebutProjet = $dateDebutProjet;

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

    public function getMotifRetard(): ?string
    {
        return $this->motifRetard;
    }

    public function setMotifRetard(?string $motifRetard): self
    {
        $this->motifRetard = $motifRetard;

        return $this;
    }

    public function getDateDerniereMiseAJour(): ?\DateTimeInterface
    {
        return $this->dateDerniereMiseAJour;
    }

    public function setDateDerniereMiseAJour(?\DateTimeInterface $dateDerniereMiseAJour): self
    {
        $this->dateDerniereMiseAJour = $dateDerniereMiseAJour;

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

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setTache($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getTache() === $this) {
                $notification->setTache(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personel>
     */
    public function getAttribuer(): Collection
    {
        return $this->attribuer;
    }

    public function addAttribuer(Personel $attribuer): self
    {
        if (!$this->attribuer->contains($attribuer)) {
            $this->attribuer[] = $attribuer;
        }

        return $this;
    }

    public function removeAttribuer(Personel $attribuer): self
    {
        $this->attribuer->removeElement($attribuer);

        return $this;
    }

     


   
}
