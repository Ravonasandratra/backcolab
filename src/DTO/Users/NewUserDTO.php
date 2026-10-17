<?php

namespace App\DTO\Users;

use Symfony\Component\Validator\Constraints as Assert;


class NewUserDTO {

    #[Assert\NotBlank()]
    #[Assert\Length(min: 3)]
	public String $firstname;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 3)]
	public String $lastname;


    #[Assert\NotBlank()]
	public String $phone;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 3)]
	public String $description;

    #[Assert\NotBlank()]
    #[Assert\Email]
	public String $email;
    
    #[Assert\Type("bool")]
	public Bool $isDemanded;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 8)]
    public String $password;

    #[Assert\Expression(
        "this.getPassword() === value",
        message: "Les mots de passe ne correspondent pas."
    )]
    public String $confirmPassword;

     public function getPassword(): ?String
    {
        return $this->password;
    } 
}