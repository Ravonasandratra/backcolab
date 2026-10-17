<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function listingUserWhithFilter(
        ?String $domain = null, 
        ?String $category = null, 
        ?String $subCategory = null, 
        ?int $page = 1, 
        ?int $lim = 2,
        ?int $currentUser = null
        ): Paginator
        
    {
        $query = $this->createQueryBuilder('u');


        if($currentUser) {
            $query->where("u.id != :userId")
                ->setParameter("userId", $currentUser);
        }

        $query->join('u.subCategories', 'sc')->addSelect('sc');
        if($domain){
            $query->join('sc.category', 'category')
                ->join('category.domain', "domain")
                ->andWhere("domain.name = :domaine")
                ->setParameter("domaine", $domain);
        };

        if($category) {
            $query->join('sc.category', 'category')
                ->andWhere("category.name = :category")
                ->setParameter("category", $category);
        };

        if($subCategory) {
            $query->andWhere('sc.name = :subcategory')
                ->setParameter("subcategory", $subCategory);
        };
        $query->orderBy("u.id", "ASC")
            ->setFirstResult(($page - 1) * $lim)
            ->setMaxResults($lim)
            ->setHint(Paginator::HINT_ENABLE_DISTINCT, false);

        return new Paginator($query->getQuery());
    }

    public function searchAccout(String $identity)
    {
        return $this->createQueryBuilder("u")
            ->select("u.id", "u.email", "u.phone", "u.avatar", "u.firstname", "u.lastname")
            ->where("u.email = :identity")
            ->orWhere("u.phone = :identity")
            ->setParameter("identity", $identity)
            ->getQuery()
            ->getOneOrNullResult();
            ;
    }

}
