<?php

namespace App\Tests\DTO;

use App\Tests\Trait\ValidationErrorTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractDTOTest extends KernelTestCase
{
    use ValidationErrorTrait;

    protected ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get('validator');
    }
}