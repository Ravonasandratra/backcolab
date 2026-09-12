<?php

namespace App\Entity;

use App\Repository\ExperiencesRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperiencesRepository::class)]
class Experiences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user.show"])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user.show"])]
    private ?string $post = null;

    #[ORM\Column]
    #[Groups(["user.show"])]
    private ?int $begin = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["user.show"])]
    private ?int $end = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["user.show"])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'experiences')]
    private ?user $user = null;

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

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): static
    {
        $this->post = $post;

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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}
