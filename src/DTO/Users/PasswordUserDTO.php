<?php
namespace App\DTO\Users;

use App\Validator\Pwd;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordUserDTO {
    #[Assert\NotBlank()]
    #[Pwd()]
    public ?String $password;

    #[Assert\NotBlank()]
    //#[Assert\Length(min: 8, max: 50)]
    public ?String $newPassword;

    #[Assert\NotBlank()]
    //#[Assert\Length(min: 8, max: 50)]
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