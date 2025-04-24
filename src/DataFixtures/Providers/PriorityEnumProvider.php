<?php

namespace App\DataFixtures\Providers;

use App\Enum\Priority;

class PriorityEnumProvider
{
    public function getPriority(string $priority): Priority
    {
        return Priority::from($priority);
    }
}
