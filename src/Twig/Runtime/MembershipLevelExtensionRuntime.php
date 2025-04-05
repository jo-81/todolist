<?php

namespace App\Twig\Runtime;

use App\Enum\MembershipLevel;
use Twig\Extension\RuntimeExtensionInterface;

class MembershipLevelExtensionRuntime implements RuntimeExtensionInterface
{
    public function doInformationProject(MembershipLevel $membershipLevel): string
    {
        return match ($membershipLevel) {
            MembershipLevel::VIP => "Vous n'êtes pas limité sur le nombre de projets.",
            MembershipLevel::PREMIUM => sprintf('Vous pouvez créer %d projets.', MembershipLevel::PREMIUM->getProjectLimit()),
            MembershipLevel::REGISTER => sprintf('Vous pouvez créer %d projets.', MembershipLevel::REGISTER->getProjectLimit()),
        };
    }

    public function doInformationWorkspace(MembershipLevel $membershipLevel): string
    {
        return match ($membershipLevel) {
            MembershipLevel::VIP => "Vous n'êtes pas limité sur le nombre de workspaces.",
            MembershipLevel::PREMIUM => sprintf('Vous pouvez créer %d workspaces.', MembershipLevel::PREMIUM->getWorkspaceLimit()),
            MembershipLevel::REGISTER => sprintf('Vous pouvez créer %d workspaces.', MembershipLevel::REGISTER->getWorkspaceLimit()),
        };
    }
}
