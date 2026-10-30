<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
        ?string $domain = null,
        ?string $category = null,
        ?string $subCategory = null,
        ?int $page = 1,
        ?int $lim = 2,
        ?int $currentUser = null,
        ?string $search = null,
    ): Paginator {
        $query = $this->createQueryBuilder('u');

        if ($currentUser) {
            $query->andWhere('u.id != :userId')
                ->setParameter('userId', $currentUser);
        }

        $query->join('u.subCategories', 'sc')
            ->addSelect('sc');

        if ($domain) {
            $query->join('sc.category', 'cat')
                ->join('cat.domain', 'dom')
                ->andWhere('dom.name = :domaine')
                ->setParameter('domaine', $domain);
        }

        if ($category) {
            $query->join('sc.category', 'cat')
                ->andWhere('cat.name = :category')
                ->setParameter('category', $category);
        }

        if ($subCategory) {
            $query->andWhere('sc.name = :subcategory')
                ->setParameter('subcategory', $subCategory);
        }

        // Recherche par nom ou prénom
        if ($search !== null && trim($search) !== '') {
            $search = mb_strtolower(trim($search));

            $query->andWhere(
                "(
                    LOWER(CONCAT(u.lastname, CONCAT(' ', u.firstname)))
                        LIKE :search
                    OR
                    LOWER(CONCAT(u.firstname, CONCAT(' ', u.lastname)))
                        LIKE :search
                )"
            )
            ->setParameter('search', '%' . $search . '%');
        }


        $query->orderBy('u.id', 'ASC')
            ->setFirstResult(($page - 1) * $lim)
            ->setMaxResults($lim)
            ->setHint(Paginator::HINT_ENABLE_DISTINCT, true);

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
