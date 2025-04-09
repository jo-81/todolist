<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WorkspaceController extends AbstractController
{
    #[Route('/workspaces', name: 'workspace.index')]
    public function index(): Response
    {
        return $this->render('workspace/index.html.twig', [
            'controller_name' => 'WorkspaceController',
        ]);
    }
}
