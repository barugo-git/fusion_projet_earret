<?php

namespace App\Utility;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DbProcessor
{
    private $request;
    private $security;
    private $tokenStorage;

    public function __construct(RequestStack $requestStack, Security $security, TokenStorageInterface $tokenStorage)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->security = $security;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke($record)
    {
        // On modifie le $record pour ajouter nos infos
        $record['extra']['ClientIp'] = $this->request->getClientIp();
        $record['extra']['Url'] = $this->request->getBaseUrl();
        // $record['extra']['user'] = $this->tokenStorage->getToken()->getUser();
        $record['extra']['route'] = $this->request->attributes->get('_route');

        // dd($record);
        return $record;
    }
}
