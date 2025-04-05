<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\Trait\EntityFinderTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

final class ProfileControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use EntityFinderTrait;

    /**
     * testAccessWhenUserLogged.
     */
    public function testAccessWhenUserLogged(): void
    {
        $client = static::createClient();
        /** @var User */
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $client->loginUser($testUser);

        $client->request('GET', '/profile');

        self::assertResponseIsSuccessful();
    }

    /**
     * testNotAccessWhenUserNotLogged.
     */
    public function testNotAccessWhenUserNotLogged(): void
    {
        $client = static::createClient();
        $client->request('GET', '/profile');

        self::assertResponseRedirects('/connexion');
    }
}
