<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Section;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Section>
 */
class SectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }
    
    /**
     * findSectionsQuery
     *
     * @param  Project $project
     * @param  string $query
     * @return Section[]
     */
    public function findSectionsQuery(Project $project, string $query)
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.project = :project')
            ->setParameter('project', $project)
        ;

        if (!empty($query)) {
            $qb
                ->andWhere('s.name LIKE :query')
                ->setParameter('query', '%'.$query.'%')
            ;
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Section[] Returns an array of Section objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Section
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
