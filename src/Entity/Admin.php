<?php

namespace App\Entity;

use App\Enum\MembershipLevel;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Admin extends User
{
    #[ORM\PrePersist]
    public function setPersistValue(): void
    {
        $this->roles = ["ROLE_ADMIN"];
        $this->membershipLevel = MembershipLevel::VIP;
    }
}
