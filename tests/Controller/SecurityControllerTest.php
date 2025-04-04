<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class SecurityControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * testRouteLoginExist.
     */
    public function testRouteLoginExist(): void
    {
        $this->client->request('GET', '/connexion');

        self::assertResponseIsSuccessful();
    }

    /**
     * testLoginWithBadCredentials.
     */
    public function testLoginWithBadCredentials(): void
    {
        $this->client->request('GET', '/connexion');
        $this->client->submitForm('Connexion', [
            'email' => 'admin789@domaine.fr',
            'password' => '0',
        ]);

        self::assertResponseRedirects('/connexion');
        $this->client->followRedirect();

        self::assertSelectorTextContains('.alert-danger', 'Identifiants invalides.');
    }

    /**
     * testSuccessLogin.
     */
    public function testSuccessLogin(): void
    {
        $this->client->request('GET', '/connexion');
        $this->client->submitForm('Connexion', [
            'email' => 'admin@domaine.fr',
            'password' => '0000',
        ]);

        self::assertResponseRedirects('/profile');
        $this->client->followRedirect();
        self::assertSelectorTextContains('.toast.text-bg-success', 'Bienvenue admin, vous êtes connecté !');
    }

    /**
     * testRedirectionWhenUserLogged.
     */
    public function testRedirectionWhenUserLogged(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        /** @var User */
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/connexion');

        self::assertResponseRedirects('/');
        $this->client->followRedirect();
        self::assertSelectorTextContains('.toast.text-bg-info', 'Vous êtes déjà connecté.');
    }
}
