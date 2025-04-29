<?php

namespace App\Tests\Component\Task;

use App\Entity\Task;
use App\Entity\User;
use App\Enum\Priority;
use App\Entity\Section;
use App\Tests\Trait\EntityFinderTrait;
use App\Twig\Components\Task\TaskRegisterForm;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class TaskRegisterFormTest extends WebTestCase
{
    use InteractsWithTwigComponents;
    use InteractsWithLiveComponents;
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    public function testSubmitSectionFormComponent(): void
    {
        $client = static::createClient();
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $component = $this->createLiveComponent(
            name: TaskRegisterForm::class,
            data: ['section' => $this->findEntity(Section::class, 1)],
            client: $client,
        );

        $component->actingAs($user);
        $component->submitForm(['task_register' => [
            'title' => 'A new task',
            'content' => 'A description',
            'priority' => Priority::HIGHT,
        ]], 'save');

        $newTask = $this->findOneEntityBy(Task::class, ['title' => 'A new task']);
        self::assertInstanceOf(Task::class, $newTask);
    }
}
