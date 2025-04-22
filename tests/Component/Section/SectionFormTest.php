<?php

namespace App\Tests\Component\Workspace;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Section;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Section\SectionForm;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SectionFormTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    /**
     * testRenderedComponent.
     */
    public function testRenderedSectionFormComponent(): void
    {
        $component = $this->createLiveComponent(
            name: SectionForm::class,
            data: ['project' => $this->findEntity(Project::class, 1)],
        );

        $component->actingAs($this->findEntity(User::class, 1));

        $this->assertStringContainsString('section[name]', $component->render());
        $this->assertStringContainsString('section[description]', $component->render());
    }

    /**
     * testRenderedSectionFormComponentWhenUserNotLogged.
     */
    public function testRenderedSectionFormComponentWhenUserNotLogged(): void
    {
        $this->expectException(AccessDeniedException::class);

        $component = $this->createLiveComponent(
            name: SectionForm::class,
            data: ['project' => $this->findEntity(Project::class, 1)],
        );

        $component->render();
    }

    /**
     * testSubmitSectionFormComponent.
     */
    public function testSubmitSectionFormComponent(): void
    {
        $client = static::createClient();
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $component = $this->createLiveComponent(
            name: SectionForm::class,
            data: ['project' => $this->findEntity(Project::class, 1)],
            client: $client,
        );

        $component->actingAs($user);
        $component->submitForm(['section' => [
            'name' => 'A new section',
            'description' => 'A description',
        ]], 'save');

        $newSection = $this->findOneEntityBy(Section::class, ['name' => 'A new section']);

        self::assertInstanceOf(Section::class, $newSection);
        $client->followRedirect();
        self::assertSelectorTextContains('.toast.text-bg-success', 'Section créé !');
    }

    /**
     * testSubmitFormComponentWhenUserNotLogged.
     */
    public function testSubmitSectionFormComponentWhenUserNotLogged(): void
    {
        $this->expectException(AccessDeniedException::class);

        $client = static::createClient();
        $component = $this->createLiveComponent(
            name: SectionForm::class,
            data: ['project' => $this->findEntity(Project::class, 1)],
            client: $client,
        );

        $component->submitForm(['section' => [
            'name' => 'A new section',
            'description' => 'A description',
        ]], 'save');
    }
}
