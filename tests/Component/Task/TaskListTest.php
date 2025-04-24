<?php

namespace App\Tests\Component\Task;

use App\Entity\User;
use App\Entity\Section;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Task\TaskList;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TaskListTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    public function testRenderedTaskListComponent(): void
    {
        $component = $this->createLiveComponent(
            name: TaskList::class,
            data: ['section' => $this->findEntity(Section::class, 1)],
        );

        $component->actingAs($this->findEntity(User::class, 1));

        $this->assertStringContainsString('Task 1', $component->render());
    }

    public function testRenderedTaskListComponentWhenUserNotLogged(): void
    {
        $this->expectException(AccessDeniedException::class);

        $component = $this->createLiveComponent(
            name: TaskList::class,
            data: ['section' => $this->findEntity(Section::class, 1)],
        );

        $component->render();
    }
}
