<?php

namespace App\Tests\DTO;

use App\Enum\Priority;
use App\DTO\Task\TaskRegisterDTO;

class TaskDTOTest extends AbstractDTOTest
{
    /**
     * testPropertyTitle.
     */
    public function testPropertyTitle(): void
    {
        $entity = $this->getEntity();

        /* Champ requis */
        $entity->setTitle('');
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);

        /* Regex */
        $entity->setTitle('<script></scritp>');
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
    }

    /**
     * testPropertyLimitedAt.
     */
    public function testPropertyLimitedAt(): void
    {
        $entity = $this->getEntity();

        /* Champ requis */
        $entity->setLimitedAt(new \DateTimeImmutable('2025-01-01'));
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
    }

    private function getEntity(): TaskRegisterDTO
    {
        return (new TaskRegisterDTO())
            ->setTitle('Une nouvelle tâche')
            ->setContent('Une description du projet 11')
            ->setPriority(Priority::HIGHT)
        ;
    }
}
