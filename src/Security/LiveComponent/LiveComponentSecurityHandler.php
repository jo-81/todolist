<?php

namespace App\Security\LiveComponent;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class LiveComponentSecurityHandler
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    public function handleComponentSecurity(object $component): void
    {
        // Récupérer la classe du composant
        $reflectionClass = new \ReflectionClass($component);

        // Vérifier les attributs IsGranted au niveau de la classe
        foreach ($reflectionClass->getAttributes(IsGranted::class) as $attribute) {
            $isGranted = $attribute->newInstance();
            $attributes = is_array($isGranted->attribute) ? $isGranted->attribute : [$isGranted->attribute];
            $this->checkPermission($attributes, $isGranted->subject);
        }
    }

    private function checkPermission(array $attributes, mixed $subject = null): void
    {
        foreach ($attributes as $attribute) {
            if (!$this->authorizationChecker->isGranted($attribute, $subject)) {
                throw new AccessDeniedException('Accès refusé au Live Component.');
            }
        }
    }
}
