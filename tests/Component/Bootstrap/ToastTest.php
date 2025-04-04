<?php

namespace App\Tests\Component\Bootstrap;

use App\Twig\Components\Bootstrap\Toast;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class ToastTest extends WebTestCase
{
    use InteractsWithTwigComponents;

    public function testRenderedComponent(): void
    {
        $rendered = $this->renderTwigComponent(
            name: Toast::class,
            data: ['type' => 'info', 'message' => 'Un message.'],
        );

        $this->assertStringContainsString('info', (string) $rendered);
        $this->assertStringContainsString('Un message.', (string) $rendered);
    }
}
