<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\Trait\EntityFinderTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

final class ProjectControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use EntityFinderTrait;

    /**
     * testAccessWhenUserNotLoggedIndex.
     *
     * @dataProvider getProjectPath
     */
    public function testAccessWhenUserNotLoggedIndex(string $method, string $path): void
    {
        $client = static::createClient();
        $client->request($method, $path);

        self::assertResponseRedirects('/connexion');
    }

    /**
     * testAccessWhenUserLoggedIndex.
     *
     * @dataProvider getProjectPath
     */
    public function testAccessWhenUserLoggedIndex(string $method, string $path): void
    {
        $client = static::createClient();
        /** @var User */
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $client->loginUser($testUser);
        $client->request($method, $path);

        self::assertResponseIsSuccessful();
    }

    public static function getProjectPath(): array
    {
        return [
            ['GET', '/projects/project-1'],
        ];
    }
}
