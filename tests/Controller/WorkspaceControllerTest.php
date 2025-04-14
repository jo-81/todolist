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
     *
     * @dataProvider getWorkspacePath
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

    /**
     * testRemoveWorkspaceWhenUserNotLogged.
     */
    public function testRemoveWorkspaceWhenUserNotLogged(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/workspaces/remove/1');

        self::assertResponseRedirects('/connexion');
    }

    public static function getWorkspacePath(): array
    {
        return [
            ['GET', '/workspaces'],
            ['GET', '/workspaces/workspace-1'],
        ];
    }
}
