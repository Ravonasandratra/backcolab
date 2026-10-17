<?php
namespace App\DTO\Users;

use Symfony\Component\Validator\Constraints as Assert;

class ProfilUserDTO {

    #[Assert\Length(min: 3)]
    #[Assert\NotBlank()]
    public ?String $firstname;

    #[Assert\Length(min: 3)]
    #[Assert\NotBlank()]
    public ?String $lastname;

    #[Assert\Length(min: 5)]
    #[Assert\NotBlank()]
    public ?String $description;
}