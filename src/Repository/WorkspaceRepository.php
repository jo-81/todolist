<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Workspace;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Workspace>
 */
class WorkspaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workspace::class);
    }

    /**
     * findWorkspaceQuery.
     *
     * @return Workspace[]
     */
    public function findWorkspaceQuery(User $user, string $query)
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.owner = :owner')
            ->setParameter('owner', $user)
            ->orderBy('p.createdAt', 'DESC')
        ;

        if (!empty($query)) {
            $qb
                ->andWhere('p.name LIKE :query')
                ->setParameter('query', '%'.$query.'%')
            ;
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Workspace[] Returns an array of Workspace objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Workspace
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
