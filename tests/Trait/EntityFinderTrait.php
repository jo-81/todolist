<?php

namespace App\Tests\Trait;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

trait EntityFinderTrait
{
    /**
     * Trouve une entité par son ID.
     */
    protected function findEntity(string $entityClass, int $id): ?object
    {
        return $this->getEntityManager()->find($entityClass, $id);
    }

    /**
     * Trouve une entité par un critère spécifique.
     */
    protected function findOneEntityBy(string $entityClass, array $criteria): ?object
    {
        return $this->getEntityManager()->getRepository($entityClass)->findOneBy($criteria);
    }

    /**
     * Trouve plusieurs entités par des critères.
     */
    protected function findEntitiesBy(string $entityClass, array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        return $this->getEntityManager()->getRepository($entityClass)->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Trouve toutes les entités d'un type donné.
     */
    protected function findAllEntities(string $entityClass): array
    {
        return $this->getEntityManager()->getRepository($entityClass)->findAll();
    }

    /**
     * Compte le nombre d'entités correspondant aux critères.
     */
    protected function countEntities(string $entityClass, array $criteria = []): int
    {
        $repository = $this->getEntityManager()->getRepository($entityClass);
        $qb = $repository->createQueryBuilder('e');

        foreach ($criteria as $field => $value) {
            $qb->andWhere("e.$field = :$field")
                ->setParameter($field, $value);
        }

        return (int) $qb->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Récupère l'EntityManager.
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        if (method_exists($this, 'getContainer')) {
            // Pour les tests qui étendent KernelTestCase ou WebTestCase
            return $this->getContainer()->get('doctrine')->getManager();
        } elseif (property_exists($this, 'kernel') && $this->kernel instanceof KernelInterface) {
            // Si le kernel est disponible directement
            return $this->kernel->getContainer()->get('doctrine')->getManager();
        } elseif (method_exists($this, 'getClient') && $this->getClient()) {
            // Si un client est disponible (WebTestCase)
            return $this->getClient()->getContainer()->get('doctrine')->getManager();
        }

        throw new \LogicException('Impossible de récupérer l\'EntityManager. Assurez-vous que ce trait est utilisé dans une classe qui étend KernelTestCase ou WebTestCase.');
    }

    /**
     * Rafraîchit une entité depuis la base de données.
     */
    protected function refreshEntity(object $entity): object
    {
        $this->getEntityManager()->refresh($entity);

        return $entity;
    }
}
