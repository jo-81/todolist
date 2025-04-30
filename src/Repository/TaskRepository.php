<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Section;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function filterListTasks(Section $section, string $status, string $priority, string $archived, string $completed)
    {
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.section = :section')
            ->setParameter('section', $section)
            ->orderBy('t.createdAt', 'DESC')
        ;

        if (!empty($status)) {
            $qb
                ->andWhere('t.status = :status')
                ->setParameter('status', $status)
            ;
        }

        if (!empty($priority)) {
            $qb
                ->andWhere('t.priority = :priority')
                ->setParameter('priority', $priority)
            ;
        }

        if (in_array($archived, [0, 1])) {
            $qb
                ->andWhere('t.archived = :archived')
                ->setParameter('archived', $archived)
            ;
        }

        if (in_array($completed, [0, 1])) {
            $qb
                ->andWhere('t.completed = :completed')
                ->setParameter('completed', $completed)
            ;
        }

        return $qb->getQuery()->getResult();
    }
}
