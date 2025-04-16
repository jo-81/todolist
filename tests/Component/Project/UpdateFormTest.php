<?php

namespace App\Tests\Component\Project;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Workspace;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Project\RegisterForm;
use App\Twig\Components\Project\UpdateForm;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class UpdateFormTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    public function testRenderedComponentUpdateForm(): void
    {
        $rendered = $this->renderTwigComponent(
            name: UpdateForm::class,
            data: ['project' => $this->getProject()]
        );

        $this->assertStringContainsString('project_update[name]', (string) $rendered);
        $this->assertStringContainsString('Nombre de caractères : entre 3 et 20.', (string) $rendered);
        $this->assertStringContainsString('project_update[description]', (string) $rendered);
        $this->assertStringContainsString('Nombre de caractères restant', (string) $rendered);
        $this->assertStringContainsString('Archivé ?', (string) $rendered);
        $this->assertStringContainsString('project_update[archived]', (string) $rendered);
    }

    /**
     * testSubmitFormComponent.
     */
    public function testSubmitFormComponent(): void
    {
        $client = static::createClient();
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $component = $this->createLiveComponent(
            name: UpdateForm::class,
            client: $client,
            data: ['project' => $this->getProject()]
        );

        $component->actingAs($user);
        $component->submitForm(['project_update' => [
            'name' => 'project update',
            'description' => 'A description update',
            'archived' => true,
        ]], 'update');

        $newProject = $this->findOneEntityBy(Project::class, ['name' => 'project update']);

        self::assertInstanceOf(Project::class, $newProject);
        $client->followRedirect('/projects/project-update');
        self::assertSelectorTextContains('.toast.text-bg-success', 'Projet modifié !');
    }

    private function getProject(): Project
    {
        return $this->findEntity(Project::class, 1);
    }
}
