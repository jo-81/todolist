<?php

namespace App\Controller;

use App\Entity\Workspace;
use App\Service\WorkspaceManagementService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WorkspaceController extends AbstractController
{
    public function __construct(private WorkspaceManagementService $workspaceManagementService)
    {
    }

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

    #[Route('/workspaces/remove/{id}', name: 'workspace.remove', methods: ['DELETE'])]
    public function remove(Workspace $workspace, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('workspace_remove', $request->request->get('_csrf_token'))) {
            $this->addFlash('danger', 'Jeton CSRF invalide.');

            return $this->redirectToRoute('workspace.show', ['slug' => $workspace->getSlug()]);
        }

        try {
            $this->workspaceManagementService->remove($workspace);
            $this->addFlash('success', 'Workspace supprimé !');

            return $this->redirectToRoute('workspace.index');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression du workspace.');

            return $this->redirectToRoute('workspace.show', ['slug' => $workspace->getSlug()]);
        }
    }
}
