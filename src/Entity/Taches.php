<?php

namespace App\Entity;

use App\Repository\TachesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TachesRepository::class)]
class Taches 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['gettaches'])]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['gettaches'])]
    private $resume;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['gettaches'])]
    private $priorite;

    #[ORM\Column(type: 'date')]
    #[Groups(['gettaches'])]
    private $dateDebutProjet;

    #[ORM\Column(type: 'date')]
    #[Groups(['gettaches'])]
    private $dateFinEstimeProj;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['gettaches'])]
    private $motifRetard;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['gettaches'])]
    private $dateDerniereMiseAJour;

    #[ORM\OneToMany(mappedBy: 'notif', targetEntity: Notifications::class)]
    private $notifications;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
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

    /**
     * @return Collection<int, Notifications>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notifications $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setNotif($this);
        }

        return $this;
    }

    public function removeNotification(Notifications $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getNotif() === $this) {
                $notification->setNotif(null);
            }
        }

        return $this;
    }
}
