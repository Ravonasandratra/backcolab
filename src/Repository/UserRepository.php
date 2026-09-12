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
        ?String $domain = null, 
        ?String $category = null, 
        ?String $subCategory = null, 
        ?int $page = 1, 
        ?int $lim = 2): Paginator
    {
        $query = $this->createQueryBuilder('u')
            ->join('u.subCategories', 'sc')
            ->addSelect('sc');
        if($domain){
            $query->join('sc.category', 'category')
                ->join('category.domain', "domain")
                ->where("domain.name LIKE :domaine")
                ->setParameter("domaine", "%".$domain."%");
        };

        if($category) {
            $query->join('sc.category', 'category')
                ->where("category.name LIKE :category")
                ->setParameter("category", "%".$category."%");
        };

        if($subCategory) {
            $query->where('sc.name LIKE :subcategory')
                ->setParameter("subcategory", "%".$subCategory."%");
        };
        $query->orderBy("u.id", "ASC")
            ->setFirstResult(($page - 1) * $lim)
            ->setMaxResults($lim)
            ->setHint(Paginator::HINT_ENABLE_DISTINCT, false);
        return new Paginator($query->getQuery());
    }

}
