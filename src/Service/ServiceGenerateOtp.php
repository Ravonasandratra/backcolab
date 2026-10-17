<?php
namespace App\Service;

use OTPHP\TOTP;

class ServiceGenerateOtp {

    public function generateSecret(): string {
        return TOTP::generate()->getSecret();
    }

    public function generateCode(String $secret): String {
        return TOTP::createFromSecret($secret)
        ->withPeriod(300)
        ->withDigits(6)
        ->now();
    }
    public function verifyCode(String $secret, String $code): bool {

        return TOTP::createFromSecret($secret)
            ->withDigits(6)
            ->withPeriod(300)
            ->verify($code);
    }
};