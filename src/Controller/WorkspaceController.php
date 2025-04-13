<?php

namespace App\Controller;

use App\Entity\Workspace;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WorkspaceController extends AbstractController
{
    #[Route('/workspaces', name: 'workspace.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('workspace/index.html.twig');
    }

    #[Route('/workspaces/{slug}', name: 'workspace.show', methods: ['GET'], priority: 5)]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Workspace $workspace): Response
    {
        return $this->render('workspace/show.html.twig', [
            'workspace' => $workspace,
        ]);
    }
}
