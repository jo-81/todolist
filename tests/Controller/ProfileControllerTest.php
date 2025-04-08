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
     *
     * @dataProvider getDataProviderPageProfile
     */
    public function testAccessWhenUserLogged(string $method, string $path): void
    {
        $client = static::createClient();
        /** @var User */
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $client->loginUser($testUser);

        $client->request($method, $path);

        self::assertResponseIsSuccessful();
    }

    /**
     * testNotAccessWhenUserNotLogged.
     *
     * @dataProvider getDataProviderPageProfile
     */
    public function testNotAccessWhenUserNotLogged(string $method, string $path): void
    {
        $client = static::createClient();
        $client->request($method, $path);

        self::assertResponseRedirects('/connexion');
    }

    public static function getDataProviderPageProfile(): array
    {
        return [
            ['GET', '/profile'],
            ['GET', '/profile/edit'],
        ];
    }

    public function testUpdateProfile(): void
    {
        $client = static::createClient();
        /** @var User */
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $client->loginUser($testUser);

        $client->request('GET', '/profile/edit');
        $client->submitForm('Enregistrer', [
            'edit_profile[email]' => 'admin1@domaine.com',
        ]);

        $userEdit = $this->findEntity(User::class, 1);

        self::assertResponseRedirects('/profile');
        $client->followRedirect();

        self::assertSelectorTextContains('.toast.text-bg-success', 'Votre profil a bien été modifié.');
        self::assertEquals('admin1@domaine.com', $userEdit?->getEmail());
    }
}
