<?php
namespace App\DTO\Users;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordUserResetDTO {

    #[Assert\NotBlank()]
    #[Assert\Length(min: 8, max: 50)]
    public ?String $newPassword;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 8, max: 50)]
    #[Assert\Expression(
        "this.getNewPassword() === value",
        message: "Les mots de passe ne correspondent pas."
    )]
    public ?String $confirmedPassword;

    public function getNewPassword(): ?String
    {
        return $this->newPassword;
    } 
}