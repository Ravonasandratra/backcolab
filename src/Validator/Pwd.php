<?php

namespace App\Validator;

use phpDocumentor\Reflection\Types\Parent_;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Pwd extends Constraint
{
    public function __construct(mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        Parent::__construct($options,$groups,$payload);
    }
    public string $message = 'Mot de passe incorrecte!';
}
