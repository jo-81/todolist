<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Workspace;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class WorkspaceVoter extends Voter
{
    public const REGISTER = 'WORKSPACE_REGISTER';
    public const EDIT = 'WORKSPACE_EDIT';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::REGISTER, self::EDIT]) && $subject instanceof Workspace;
    }
    
    /**
     * voteOnAttribute
     *
     * @param  Workspace $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::REGISTER:
                return $user instanceof User;

                break;

            case self::EDIT:
                return $subject->getOwner() == $user;

                break;
        }

        return false;
    }
}
