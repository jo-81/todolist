<?php

namespace App\Tests\Component\Bootstrap;

use App\Twig\Components\Bootstrap\Alert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class AlertTest extends KernelTestCase
{
    use InteractsWithTwigComponents;

    public function testRenderedComponent(): void
    {
        $rendered = $this->renderTwigComponent(
            name: Alert::class,
            data: ['type' => 'info', 'message' => 'Un message.'],
        );

        $this->assertStringContainsString('info', (string) $rendered);
        $this->assertStringContainsString('Un message.', (string) $rendered);
    }
}
