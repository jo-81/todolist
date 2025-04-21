<?php

namespace App\Tests\Component\Workspace;

use App\Entity\User;
use App\Entity\Workspace;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Workspace\EditForm;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EditFormTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    /**
     * testRenderedComponentForEdit.
     */
    public function testRenderedComponentForEdit(): void
    {
        $rendered = $this->renderTwigComponent(
            name: EditForm::class,
            data: ['workspace' => $this->getWorkspace()]
        );

        $this->assertStringContainsString('Workspace 1', (string) $rendered);
    }

    public function testSubmitEditFormComponent(): void
    {
        $client = static::createClient();
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $component = $this->createLiveComponent(
            name: EditForm::class,
            client: $client,
            data: ['workspace' => $this->getWorkspace()],
        );

        $component->actingAs($user);
        $component->submitForm(['workspace' => [
            'name' => 'A update Workspace',
        ]], 'update');

        $newWorkspace = $this->findOneEntityBy(Workspace::class, ['name' => 'A update Workspace']);

        self::assertInstanceOf(Workspace::class, $newWorkspace);
        $client->followRedirect('/workspaces/'.$newWorkspace->getSlug());
        self::assertSelectorTextContains('.toast.text-bg-success', 'Workspace modifié !');
    }

    /**
     * testSubmitEditFormComponentWhenUserNotLogged.
     */
    public function testSubmitEditFormComponentWhenUserNotLogged(): void
    {
        $this->expectException(AccessDeniedException::class);

        $client = static::createClient();
        $component = $this->createLiveComponent(
            name: EditForm::class,
            client: $client,
            data: ['workspace' => $this->getWorkspace()],
        );

        $component->submitForm(['workspace' => [
            'name' => 'A update Workspace',
        ]], 'update');
    }

    /**
     * getWorkspace.
     */
    private function getWorkspace(): Workspace
    {
        return $this->findEntity(Workspace::class, 1);
    }
}
