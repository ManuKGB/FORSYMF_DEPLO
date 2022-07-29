<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
   #[Groups(['getNotif'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['getNotif'])]
    private $codeNotif;

    #[ORM\Column(type: 'text')]
    #[Groups(['getNotif'])]
    #[Assert\NotBlank(message: "La saisie du contenu de la notification est importante.")]
    private $contenuNotif;

    #[ORM\Column(type: 'date')]
    #[Groups(['getNotif'])]
    #[Assert\NotBlank(message: "La saisie de la date à laquelle la notification est apparue est importante.")]
    private $dateNotif;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[Groups(['getNotif'])]

    private ?Taches $tache = null;

   



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeNotif(): ?string
    {
        return $this->codeNotif;
    }

    public function setCodeNotif(?string $codeNotif): self
    {
        $this->codeNotif = $codeNotif;

        return $this;
    }

    public function getContenuNotif(): ?string
    {
        return $this->contenuNotif;
    }

    public function setContenuNotif(string $contenuNotif): self
    {
        $this->contenuNotif = $contenuNotif;

        return $this;
    }

    public function getDateNotif(): ?\DateTimeInterface
    {
        return $this->dateNotif;
    }

    public function setDateNotif(\DateTimeInterface $dateNotif): self
    {
        $this->dateNotif = $dateNotif;

        return $this;
    }

    public function getTache(): ?Taches
    {
        return $this->tache;
    }

    public function setTache(?Taches $tache): self
    {
        $this->tache = $tache;

        return $this;
    }



  
}
