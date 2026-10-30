<?php

namespace App\Entity;

use App\Repository\FormationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationsRepository::class)]
class Formations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user.show"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user.show", "formation.post"])]
    #[Assert\NotBlank()]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'date')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user.show", "formation.post"])]
    #[Assert\NotBlank()]
    private ?string $school = null;

    #[ORM\Column]
    #[Groups(["user.show", "formation.post"])]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    private ?int $begin = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["user.show", "formation.post"])]
    private ?int $end = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["user.show", "formation.post"])]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getSchool(): ?string
    {
        return $this->school;
    }

    public function setSchool(string $school): static
    {
        $this->school = $school;

        return $this;
    }

    public function getBegin(): ?int
    {
        return $this->begin;
    }

    public function setBegin(int $begin): static
    {
        $this->begin = $begin;

        return $this;
    }

    public function getEnd(): ?int
    {
        return $this->end;
    }

    public function setEnd(?int $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
