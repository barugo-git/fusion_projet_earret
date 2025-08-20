<?php


namespace App\Service;

namespace App\Service;



use App\Repository\MesuresInstructionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AlerteMesureInstructionService
{
    private $mesureInstructionRepository;
    private $entityManager;
    private $security;

    public function __construct(
        MesuresInstructionsRepository $mesureInstructionRepository,
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->mesureInstructionRepository = $mesureInstructionRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function verifierDelais(): array
    {
        $user = $this->security->getUser();
        $mesures = $this->mesureInstructionRepository->findByGreffier($user);
       // dd($mesures);

        $alertes = [];
        $now = new \DateTime();

        foreach ($mesures as $mesure) {
            if ($mesure->getTermineAt() <= $now && !$mesure->isAlerteEnvoyee()) {
                $alertes[] = $mesure;
                $mesure->setAlerteEnvoyee(true);
                $this->entityManager->persist($mesure);
            }
        }

        $this->entityManager->flush();
        return $alertes;
    }

    /**
     * Compte le nombre d'alertes non lues.
     */
    public function compterAlertes(): int
    {
        $greffier = $this->security->getUser();
        $mesures = $this->mesureInstructionRepository->findByGreffier($greffier);

        $now = new \DateTime();
        $count = 0;

        foreach ($mesures as $mesure) {
            if ($mesure->getTermineAt() <= $now && !$mesure->isAlerteEnvoyee()) {
                $count++;


            }
        }

        return $count;
    }

}