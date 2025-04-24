<?php

namespace App\DataFixtures\Providers;

use App\Enum\Status;

class StatusEnumProvider
{
    public function getStatus(string $status): Status
    {
        return Status::from($status);
    }
}
