<?php

namespace App\Tests\Component\Section;

use App\Entity\User;
use App\Entity\Section;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Section\SectionCard;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SectionCardTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    /**
     * testRenderedSectionCardComponent.
     */
    public function testRenderedSectionCardComponent(): void
    {
        $component = $this->createLiveComponent(
            name: SectionCard::class,
            data: ['section' => $this->findEntity(Section::class, 1)],
        );

        $component->actingAs($this->findEntity(User::class, 1));

        $this->assertStringContainsString('section 1', $component->render());
    }

    /**
     * testRemoveSectionWithComponent.
     */
    public function testRemoveSectionWithComponent(): void
    {
        $component = $this->createLiveComponent(
            name: SectionCard::class,
            data: ['section' => $this->findEntity(Section::class, 1)],
        );

        $component->actingAs($this->findEntity(User::class, 1));

        $component = $component->component();
        $component->remove();

        $sectionRemoved = $this->findEntity(Section::class, 1);
        $this->assertNull($sectionRemoved);
    }

    /**
     * testRenderedSectionListComponentWithAccessDenied.
     */
    public function testRenderedSectionListComponentWithAccessDenied(): void
    {
        $this->expectException(AccessDeniedException::class);

        $client = static::createClient();
        $component = $this->createLiveComponent(
            name: SectionCard::class,
            data: ['section' => $this->findEntity(Section::class, 1)],
            client: $client,
        );

        $component->render();
    }
}
