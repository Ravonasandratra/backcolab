<?php

namespace App\Controller\API\public;

use App\DTO\Users\NewUserDTO;
use App\DTO\Users\VerifyUserOtpDTO;
use App\Entity\Profil;
use App\Entity\User;
use App\Event\MailingVerificationEvent;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use App\Service\ServiceGenerateOtp;
use App\Service\ServiceManagerOtp;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Runtime\ResolverInterface;

final class UsersController extends AbstractController
{
    public function __construct(private readonly CacheManager $cache) {}

    #[Route('/api/public/user/{id}', name: 'api_users_show', methods: ['GET'])]
    public function index(User $user): JsonResponse
    {
        $user->getAvatar() ? $user->setAvatar($this->cache->getBrowserPath("/media/avatar/" . $user->getAvatar(), "avatar")) : null;
        return $this->json($user, 200, [], [
            "groups" => ["user.show"]
        ]);
    }

    #[Route('/api/public/user', name: 'api_users_listing', methods: ['GET'])]
    public function listingUser(
        UserRepository $userRepository,
        Request $request,
    ): JsonResponse {
        $domaine = $request->query->get("domaine");

        $category = $request->query->get("category");
        $subCategory = $request->query->get("subCategory");
        $page = $request->query->get("page") ?? 1;
        $limit = 10;

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $currentId = $currentUser ? $currentUser->getId() : null;

        if ($page < 1) {
            $page = 1;
        };
        if ($subCategory) {
            $domaine = $category = null;
        }

        if (!$subCategory && $category) {
            $domaine = null;
        };

        $users = $userRepository->listingUserWhithFilter(domain: $domaine, category: $category, subCategory: $subCategory, page: $page, lim: $limit, currentUser: $currentId);

        return $this->json($users, 200, [], [
            "groups" => ["user.listing"],
            "limit" => $limit,
            "currentpage" => (int)$page
        ]);
    }

    #[Route('/api/public/user', name: 'api_users_post', methods: ['POST'])]
    public function postUser(
        #[MapRequestPayload()]
        NewUserDTO $newUser,
        EntityManagerInterface $entityManager,
        ServiceManagerOtp $managerOtp,
        EventDispatcherInterface $eventDispatcher,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {

        $profil = new Profil();
        $user = new User();

        $user->setEmail($newUser->email);
        $user->setFirstname($newUser->firstname);
        $user->setLastname($newUser->lastname);
        $user->setIsDemanded($newUser->isDemanded);
        $user->setPhone($newUser->phone);
        $user->setDescription($newUser->description);
        $user->setPassword($hasher->hashPassword($user, $newUser->password));
        $user->setIsVerified(false);
        $user->setIsClient(true);
        $user->setLevel(1);
        $profil->setUser($user);
        

        $entityManager->persist($user);
        $entityManager->flush();

        $entityManager->persist($profil);
        $entityManager->flush();
        $code = $managerOtp->create($profil);

        try {
            $eventDispatcher->dispatch(new MailingVerificationEvent([
                "code" => $code,
                "to" => $user->getEmail()
            ])
        );
        } catch (\Exception $e) {
            return $this->json(["refus" => "Votre email ou numero de tèlèphon n' existe pas"], 422);
        }

        return $this->json(["succes" => true, "id" => $profil->getId()], 200);
    }

    #[Route('/api/public/opt/user/{id}/verify', name: 'api_users_opt_verify', methods: ['POST'])]
    public function verify(
        #[MapRequestPayload()]
        VerifyUserOtpDTO $verify,
        Profil $profil,
        ServiceGenerateOtp $generateOtp,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $user = $profil->getUser();
        $otp = $profil->getVerificationOtp()[0];

        if(!$otp) {
            return $this->json(["messages" => "OOPS, Page introuvable"], 404);
        }

        if($otp->getExpiredAt() <= new DateTimeImmutable() || $otp->getAttempts() >= 3) {
            return $this->json(["refus" => "La code de validation n'est plus disponible!"], 422);
        }

        if($currentUser && $currentUser->getId() != $user->getId()){
            return $this->json(["refus" => "Vous ne pouvez modifier cette profil"], 401);
        }

        if(!$generateOtp->verifyCode($otp->getSecret(), $verify->code)) {

            $otp->setAttempts($otp->getAttempts() + 1);
            $tentative = 3 - $otp->getAttempts();
            
            
            $entityManager->persist($otp);
            $entityManager->flush();
            return $this->json(["refus" => "Code de validation incorrect, il vous reste de ".$tentative. " tentative!"], 422);
            
        }

        if($currentUser && $currentUser->isVerified() && $otp->getNewPwd()) {
            $entityManager->remove($otp);
            $currentUser->setPassword($otp->getNewPwd());
            $entityManager->persist($currentUser);
            $entityManager->flush();
            return $this->json(["succes" => true], 200);
        }

        $entityManager->remove($otp);
        $user->setIsVerified(true);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(["succes" => true], 200);
    }

    #[Route('/api/public/opt/user/{id}/regenerate', name: 'api_users_opt_regenerate', methods: ['GET'])]
    public function regenerate(
        Profil $profil,
        ServiceManagerOtp $managerOtp,
        EventDispatcherInterface $eventDispatcher
        ): JsonResponse 
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $user = $profil->getUser();

        $otp = $profil->getVerificationOtp();

        if(!$otp[0]) {
            return $this->json(["messages" => "OOPS, Page introuvable"], 404);
        }

        if($currentUser && $currentUser->getId() != $user->getId()){
            return $this->json(["refus" => "Vous ne pouvez modifier cette profil"], 401);
        }

        

        $code = $managerOtp->create($profil);


        try {
            $eventDispatcher->dispatch(new MailingVerificationEvent([
                "code" => $code,
                "to" => $user->getEmail()
            ])
        );
        } catch (\Exception $e) {
            return $this->json(["refus" => "Votre email ou numero de tèlèphon n' existe pas"], 422);
        }

        return $this->json(["succes" => true, "id" => $profil->getId()], 200);
    }
    #[Route("/api/public/search/user/identity", name: "api_users_search", methods: ["POST"])]
    public function searchAcount(
        Request $request, 
        UserRepository $userRepository, 
        ServiceManagerOtp $managerOtp, 
        EventDispatcherInterface $eventDispatcher,
        ProfilRepository $profilRepository,
        ): JsonResponse
    {

        $identity = $request->getPayload()->get("identity") ?? "";
    
        $user = $userRepository->searchAccout($identity);

        if(!$user) {
            return $this->json(["refus" => "Aucun compte correspondant à votre identifient"], 404);
        }
        
        $profil = $profilRepository->findOneBy(["user"=>$user["id"]]);

        $code = $managerOtp->create($profil);
        
        $eventDispatcher->dispatch(new MailingVerificationEvent(["to" => $user["email"], "code" => $code]));

        return $this->json($user);
    }
}
