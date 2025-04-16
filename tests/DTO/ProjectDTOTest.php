<?php

namespace App\Tests\DTO;

use App\DTO\Project\ProjectDTO;

class ProjectDTOTest extends AbstractDTOTest
{    
    /**
     * testGoodEntity
     *
     * @return void
     */
    public function testGoodEntity(): void
    {
        $validationResults = $this->getValidationErrors($this->getEntity(), $this->validator);

        $this->assertEquals(0, $validationResults['count']);
    }
    
    /**
     * testInvalidPropertyName
     *
     * @return void
     */
    public function testInvalidPropertyName(): void
    {
        $entity = $this->getEntity();

        /* Champ requis */
        $entity->setName('');
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(2, $validationResults['count']);
        $this->assertEquals($validationResults['messages'][0], 'Ce champ ne peut pas être vide.');

        /* LENGHT */
        $entity->setName('az');
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
        $this->assertEquals($validationResults['messages'][0], 'Ce champ doit contenir un minimum de 3 caractères.');

        $entity->setName('azeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
        $this->assertEquals($validationResults['messages'][0], 'Ce champ ne peut pas contenir plus de 20 caractères.');
    }

    /**
     * testInvalidPropertyDescription.
     */
    public function testInvalidPropertyDescription(): void
    {
        $entity = $this->getEntity();

        /* MAX LENGTH : 400 */
        $entity->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
        $this->assertEquals($validationResults['messages'][0], 'Le texte ne doit pas dépasser 400 caractères.');

        /* Regex */
        $entity->setDescription('<script></scritp>');
        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
        $this->assertEquals($validationResults['messages'][0], 'Le contenu contient des éléments non autorisés.');
    }

    private function getEntity(): ProjectDTO
    {
        return (new ProjectDTO())
            ->setName('Projet 11')
            ->setDescription('Une description du projet 11')
        ;
    }
}