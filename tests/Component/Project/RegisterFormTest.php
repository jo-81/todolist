<?php

namespace App\Tests\Component\Project;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Workspace;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Project\RegisterForm;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RegisterFormTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    public function testRenderedComponentRegisterForm(): void
    {
        $rendered = $this->renderTwigComponent(
            name: RegisterForm::class,
            data: ['workspace' => $this->getWorkspace()]
        );

        $this->assertStringContainsString('project_register[name]', (string) $rendered);
        $this->assertStringContainsString('Nombre de caractères : entre 3 et 20.', (string) $rendered);
        $this->assertStringContainsString('project_register[description]', (string) $rendered);
        $this->assertStringContainsString('Nombre de caractères restant', (string) $rendered);
    }
    
    /**
     * testSubmitFormComponent
     *
     * @return void
     */
    public function testSubmitFormComponent(): void
    {
        $client = static::createClient();
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $component = $this->createLiveComponent(
            name: RegisterForm::class,
            client: $client,
            data: ['workspace' => $this->getWorkspace()]
        );

        $component->actingAs($user);
        $component->submitForm(['project_register' => [
            'name' => 'A new project',
            'description' => 'A description',
        ]], 'save');

        $newProject = $this->findOneEntityBy(Project::class, ['name' => 'A new project']);

        self::assertInstanceOf(Project::class, $newProject);
        $client->followRedirect("/workspaces/workspace-1");
        self::assertSelectorTextContains('.toast.text-bg-success', 'Projet créé !');
    }

    private function getWorkspace(): Workspace
    {
        return $this->findEntity(Workspace::class, 1);
    }
}