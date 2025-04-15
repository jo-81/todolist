<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Workspace;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findProjectsQuery(Workspace $workspace, string $query, int $archived)
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.workspace = :workspace')
            ->setParameter('workspace', $workspace)
            ->orderBy('p.createdAt', 'DESC')
        ;

        if (!empty($query)) {
            $qb
                ->andWhere('p.name LIKE :query')
                ->setParameter('query', '%'.$query.'%')
            ;
        }

        if (in_array($archived, [0, 1])) {
            $qb
                ->andWhere('p.archived = :archived')
                ->setParameter('archived', $archived)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Project[] Returns an array of Project objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Project
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
