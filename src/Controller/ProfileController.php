<?php

namespace App\Controller;

use App\Mapper\UserMapper;
use App\Form\User\EditProfileType;
use App\Service\UserManagementService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProfileController extends AbstractController
{
    public function __construct(private UserManagementService $userManagementService)
    {
    }

    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profile/edit', name: 'profile.edit', methods: ['GET', 'POST'])]
    public function update(Request $request): Response
    {
        $user = $this->getUser();
        $dto = UserMapper::toUserUpdateDTO($user);
        $form = $this->createForm(EditProfileType::class, $dto, [
            'action' => $this->generateUrl('profile.edit'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = UserMapper::updateUserFromDTO($form->getData(), $user);
                $this->userManagementService->updateEntity($user);
                $this->addFlash('success', 'Votre profil a bien été modifié.');

                return $this->redirectToRoute('profile');
            } catch (ORMException $th) {
                $this->addFlash('danger', 'Un problème est survenue lors de la modification de votre profil.');

                return $this->redirectToRoute('profile.edit');
            }
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
