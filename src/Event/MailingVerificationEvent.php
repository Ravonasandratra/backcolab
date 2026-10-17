<?php

namespace App\Event;

class MailingVerificationEvent {
    public function __construct(public array $data)
    {
    }
}