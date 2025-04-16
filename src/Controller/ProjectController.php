<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProjectController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/projects/{slug}', name: 'project.single', methods: ['GET'], priority: 5)]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/projects/remove/{id}', name: 'project.remove', methods: ['DELETE'])]
    public function remove(Project $project, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('project_remove', $request->request->get('_csrf_token'))) {
            $this->addFlash('danger', 'Jeton CSRF invalide.');

            return $this->redirectToRoute('project.single', ['slug' => $project->getSlug()]);
        }

        try {

            $workspace = $project->getWorkspace();

            $this->em->remove($project);
            $this->em->flush();

            $this->addFlash('success', 'Projet supprimé !');

            return $this->redirectToRoute('workspace.show', ['slug' => $workspace->getSlug()]);
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression du projet.');

            return $this->redirectToRoute('project.single', ['slug' => $project->getSlug()]);
        }
    }
}
