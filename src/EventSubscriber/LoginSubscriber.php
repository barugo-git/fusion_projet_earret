<?php


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use App\Service\AlerteMesureInstructionService;
class LoginSubscriber implements EventSubscriberInterface
{
    private $alerteService;

    public function __construct(AlerteMesureInstructionService $alerteService)
    {
        $this->alerteService = $alerteService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.interactive_login' => 'onLogin',
        ];
    }

    public function onLogin(InteractiveLoginEvent $event): void
    {
        $alertes = $this->alerteService->verifierDelais();

        // Stocker les alertes dans la session pour les afficher dans l'interface utilisateur
        $session = $event->getRequest()->getSession();
        $session->set('alertes_mesures', $alertes);
    }
}