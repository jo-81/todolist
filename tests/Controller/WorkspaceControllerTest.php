<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\Trait\EntityFinderTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

final class WorkspaceControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use EntityFinderTrait;

    /**
     * testAccessWhenUserNotLoggedIndex.
     *
     * @dataProvider getWorkspacePath
     */
    public function testAccessWhenUserNotLoggedIndex(string $method, string $path): void
    {
        $client = static::createClient();
        $client->request($method, $path);

        self::assertResponseRedirects('/connexion');
    }

    /**
     * testAccessWhenUserLoggedIndex.
     */
    public function testAccessWhenUserLoggedIndex(): void
    {
        $client = static::createClient();
        /** @var User */
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $client->loginUser($testUser);
        $client->request('GET', '/workspaces');

        self::assertResponseIsSuccessful();
    }

    public static function getWorkspacePath(): array
    {
        return [
            ['GET', '/workspaces'],
            ['GET', '/workspaces/workspace-1'],
        ];
    }
}
