<?php

namespace App\Tests\Component\Workspace;

use App\Entity\User;
use App\Entity\Workspace;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Workspace\Form;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class FormTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    /**
     * testRenderedComponent.
     */
    public function testRenderedComponent(): void
    {
        $rendered = $this->renderTwigComponent(
            name: Form::class,
        );

        $this->assertStringContainsString('workspace[name]', (string) $rendered);
        $this->assertStringContainsString('workspace[description]', (string) $rendered);
    }

    public function testSubmitFormComponent(): void
    {
        $client = static::createClient();
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $component = $this->createLiveComponent(
            name: Form::class,
            client: $client,
        );

        $component->actingAs($user);
        $component->submitForm(['workspace' => [
            'name' => 'A new Workspace',
            'description' => 'A description',
        ]], 'save');

        $newWorkspace = $this->findOneEntityBy(Workspace::class, ['name' => 'A new Workspace']);

        self::assertInstanceOf(Workspace::class, $newWorkspace);
        $client->followRedirect();
        self::assertSelectorTextContains('.toast.text-bg-success', 'Workspace créé !');
    }
}
