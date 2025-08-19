<?php

namespace App\Service;

use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkDetails;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomLoginLinkHandler implements LoginLinkHandlerInterface
{
    private $urlGenerator;

    private $userProvider;

    public function __construct(UrlGeneratorInterface $urlGenerator, UserProviderInterface $userProvider)
    {
        $this->urlGenerator = $urlGenerator;
        $this->userProvider = $userProvider;
    }

    public function createLoginLink(UserInterface $user, Request $request = null, ?int $lifetime = null): LoginLinkDetails
    {
// Implémentez la logique pour créer le lien de connexion
        $url = $this->urlGenerator->generate('app_login', [], UrlGeneratorInterface::ABSOLUTE_URL);

// Retournez les détails du lien de connexion
        return new LoginLinkDetails($url, new \DateTimeImmutable('+15 minutes'));
    }

    public function consumeLoginLink(Request $request): UserInterface
    {
        $token = $request->query->get('token');

        if (!$token) {
            throw new AuthenticationException('Invalid login link.');
        }

        // Logique pour obtenir l'utilisateur à partir du token
        // Par exemple, vous pouvez stocker des informations sur l'utilisateur dans le token
        // ou utiliser une autre méthode pour retrouver l'utilisateur
        $user = $this->userProvider->loadUserByIdentifier($token);

        if (!$user) {
            throw new AuthenticationException('Invalid user.');
        }

        return $user;
    }
}
