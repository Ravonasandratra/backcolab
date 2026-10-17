<?php

namespace App\DTO\Users;

use Symfony\Component\Validator\Constraints as Assert;


class VerifyUserOtpDTO {
    #[Assert\NotBlank()]
    public string $code;
}