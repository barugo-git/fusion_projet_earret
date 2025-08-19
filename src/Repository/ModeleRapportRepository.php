<?php

// src/Repository/ModeleRapportRepository.php

namespace App\Repository;

use App\Entity\ModeleRapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModeleRapport>
 */
class ModeleRapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeleRapport::class);
    }

    // src/Repository/ModeleRapportRepository.php
    
}