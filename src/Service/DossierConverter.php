<?php
// src/Service/DossierConverter.php
namespace App\Service;

use App\Entity\Dossier;
use App\Repository\DossierRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DossierConverter
{
    private $dossierRepository;

    public function __construct(DossierRepository $dossierRepository)
    {
        $this->dossierRepository = $dossierRepository;
    }

    public function convert(string $dossierId): Dossier
    {
        $dossier = $this->dossierRepository->find($dossierId);

        if (!$dossier) {
            throw new NotFoundHttpException('Dossier non trouvé.');
        }

        return $dossier;
    }
}