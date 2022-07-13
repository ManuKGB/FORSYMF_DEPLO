<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    private $contenuNotif;

    #[ORM\Column(type: 'date')]
    #[Groups(['getNotif'])]
    private $dateNotif;

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
}
