<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PwdValidator extends ConstraintValidator
{
    public function __construct(public readonly Security $security,
                                public readonly UserPasswordHasherInterface $hasher)
    {

    }
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Pwd $constraint */

        if (null === $value || '' === $value) {
            return;
        }
        $user = $this->security->getUser();
        if(!$user instanceof user){
            return;
        }
        if(!$this->hasher->isPasswordValid($user, $value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        };
    }
}
