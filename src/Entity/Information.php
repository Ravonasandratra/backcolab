<?php

namespace App\Entity;

use App\Repository\InformationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationRepository::class)]
class Information
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $town = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $openday = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $closedday = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $openhour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $closedhour = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $exception = null;

    #[ORM\ManyToOne(inversedBy: 'information')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): static
    {
        $this->town = $town;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getOpenday(): ?string
    {
        return $this->openday;
    }

    public function setOpenday(?string $openday): static
    {
        $this->openday = $openday;

        return $this;
    }

    public function getClosedday(): ?string
    {
        return $this->closedday;
    }

    public function setClosedday(?string $closedday): static
    {
        $this->closedday = $closedday;

        return $this;
    }

    public function getOpenhour(): ?\DateTime
    {
        return $this->openhour;
    }

    public function setOpenhour(?\DateTime $openhour): static
    {
        $this->openhour = $openhour;

        return $this;
    }

    public function getClosedhour(): ?\DateTime
    {
        return $this->closedhour;
    }

    public function setClosedhour(?\DateTime $closedhour): static
    {
        $this->closedhour = $closedhour;

        return $this;
    }

    public function getException(): ?string
    {
        return $this->exception;
    }

    public function setException(?string $exception): static
    {
        $this->exception = $exception;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }
}
