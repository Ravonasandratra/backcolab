<?php
namespace App\Service;

use App\Entity\Profil;
use App\Entity\VerificationOtp;
use App\Repository\VerificationOtpRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class ServiceManagerOtp {
    public function __construct(
        private ServiceGenerateOtp $serviceGenerate,
        private EntityManagerInterface $entityManager,
        private VerificationOtpRepository $verificationOtp
    )
    {
       
    }

    public function create(Profil $profil): String {
        $oldCodes = $this->verificationOtp->findBy(["profil" => $profil]);
        $lastOpt = null;

        if($oldCodes && count($oldCodes) > 0) {
            $lastOpt = $oldCodes[count($oldCodes) -1];
        }
        
        $user = $profil->getUser();

        foreach ($oldCodes as $oldCode) {
            $this->entityManager->remove($oldCode);
        };

        $secret = $this->serviceGenerate->generateSecret();
        $code = $this->serviceGenerate->generateCode($secret);
        
        $otp = new VerificationOtp();

        if($user && $user->isVerified() && $lastOpt && $lastOpt->getNewPwd()) {
            $otp->setNewPwd($lastOpt->getNewPwd());
        }

        $otp->setProfil($profil);
        $otp->setSecret($secret);
        $otp->setExpiredAt(new DateTimeImmutable("+5 minutes"));
        $otp->setAttempts(0);

        $this->entityManager->persist($otp);
        $this->entityManager->flush();

        return $code;

    }
}