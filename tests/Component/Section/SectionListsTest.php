<?php

namespace App\Tests\Component\Section;

use App\Entity\User;
use App\Entity\Project;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Section\SectionList;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SectionListsTest extends WebTestCase
{
    use InteractsWithLiveComponents;
    use InteractsWithTwigComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    /**
     * testRenderedSectionListComponent.
     */
    public function testRenderedSectionListComponent(): void
    {
        $rendered = $this->createLiveComponent(
            name: SectionList::class,
            data: ['project' => $this->findEntity(Project::class, 1)]
        );

        $rendered->actingAs($this->findEntity(User::class, 1));

        $this->assertStringContainsString('Nombre de sections : 10', $rendered->render());
    }

    /**
     * testRenderedSectionListComponentWithAccessDenied.
     */
    public function testRenderedSectionListComponentWithAccessDenied(): void
    {
        $this->expectException(AccessDeniedException::class);

        $client = static::createClient();
        $component = $this->createLiveComponent(
            name: SectionList::class,
            data: ['project' => $this->findEntity(Project::class, 1)],
            client: $client,
        );
        
        $component->render();
    }
}
