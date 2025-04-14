<?php

namespace App\Tests\Voter;

use App\Entity\User;
use App\Entity\Workspace;
use PHPUnit\Framework\TestCase;
use App\Security\Voter\WorkspaceVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class WorkspaceVoterTest extends TestCase
{
    private WorkspaceVoter $voter;
    private $token;
    private $user;
    private $workspace;

    protected function setUp(): void
    {
        $this->voter = new WorkspaceVoter();
        $this->user = $this->createMock(User::class);
        $this->workspace = $this->createMock(Workspace::class);
        $this->token = $this->createMock(TokenInterface::class);
    }

    /**
     * testUnauthenticatedUser.
     */
    public function testUnauthenticatedUser(): void
    {
        $this->token->method('getUser')->willReturn(null);

        $result = $this->voter->vote(
            $this->token,
            $this->workspace,
            [WorkspaceVoter::REGISTER]
        );

        $this->assertSame(VoterInterface::ACCESS_DENIED, $result);
    }

    /**
     * testRegisterPermission.
     */
    public function testRegisterPermission(): void
    {
        $this->token->method('getUser')->willReturn($this->user);
        $this->workspace->method('getOwner')->willReturn($this->user);

        $result = $this->voter->vote(
            $this->token,
            $this->workspace,
            [WorkspaceVoter::REGISTER]
        );

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $result);
    }

    /**
     * testEditPermission.
     */
    public function testEditPermission(): void
    {
        $this->token->method('getUser')->willReturn($this->user);
        $this->workspace->method('getOwner')->willReturn($this->user);

        $result = $this->voter->vote(
            $this->token,
            $this->workspace,
            [WorkspaceVoter::EDIT]
        );

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $result);
    }
}
