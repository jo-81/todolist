<?php

namespace App\Tests\DTO;

use App\DTO\User\UserUpdateDTO;
use App\Tests\Trait\ValidationErrorTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserUpdateDTOTest extends KernelTestCase
{
    use ValidationErrorTrait;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get('validator');
    }

    /**
     * testGoodEmail.
     */
    public function testGoodEmail(): void
    {
        $entity = new UserUpdateDTO();
        $entity->setEmail('username@domaine.fr');

        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(0, $validationResults['count']);
    }

    /**
     * testEmptyValueEmail.
     */
    public function testEmptyValueEmail(): void
    {
        $entity = new UserUpdateDTO();
        $entity->setEmail('');

        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
        $this->assertEquals('Votre adresse email ne peut pas être vide.', $validationResults['messages'][0]);
    }

    /**
     * testBadValueEmail.
     */
    public function testBadValueEmail(): void
    {
        $entity = new UserUpdateDTO();
        $entity->setEmail('username.fr');

        $validationResults = $this->getValidationErrors($entity, $this->validator);

        $this->assertEquals(1, $validationResults['count']);
        $this->assertEquals("Votre adresse email n'est pas au bon format.", $validationResults['messages'][0]);
    }
}
