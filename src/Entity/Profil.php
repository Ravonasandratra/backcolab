<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, VerificationOtp>
     */
    #[ORM\OneToMany(targetEntity: VerificationOtp::class, mappedBy: 'profil')]
    private Collection $verificationOtp;

    public function __construct()
    {
        $this->verificationOtp = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, VerificationOtp>
     */
    public function getVerificationOtp(): Collection
    {
        return $this->verificationOtp;
    }

    public function addVerificationOtp(VerificationOtp $verificationOtp): static
    {
        if (!$this->verificationOtp->contains($verificationOtp)) {
            $this->verificationOtp->add($verificationOtp);
            $verificationOtp->setProfil($this);
        }

        return $this;
    }

    public function removeVerificationOtp(VerificationOtp $verificationOtp): static
    {
        if ($this->verificationOtp->removeElement($verificationOtp)) {
            // set the owning side to null (unless already changed)
            if ($verificationOtp->getProfil() === $this) {
                $verificationOtp->setProfil(null);
            }
        }

        return $this;
    }
}
