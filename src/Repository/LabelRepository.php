<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Label;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Label>
 */
class LabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Label::class);
    }

    public function findLabelsByTask(Task $task)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.tasks', 't') // 'tasks' = nom de la propriété dans Label
            ->where('t.id = :taskId')
            ->setParameter('taskId', $task->getId())
            ->getQuery()
            ->getResult()
        ;
    }
}
