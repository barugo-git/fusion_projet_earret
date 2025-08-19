<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Symfony\Set\SensiolabsSetList;


return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
    ])

    ->withSymfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withSymfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withSets([
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        SymfonySetList::SYMFONY_61,
       SensiolabsSetList::ANNOTATIONS_TO_ATTRIBUTES,
        SymfonySetList::SYMFONY_CODE_QUALITY,
    ])
// ->withRules([
//     AddVoidReturnTypeWhereNoReturnRector::class,
//$containerConfigurator->import(DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES);
// $containerConfigurator->import(SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES);
//$containerConfigurator->import(SensiolabsSetList::FRAMEWORK_EXTRA_61);
//
;

// $containerConfigurator->import(SymfonyLevelSetList::UP_TO_SYMFONY_54);
// $containerConfigurator->import(SymfonySetList::SYMFONY_CODE_QUALITY);
// $containerConfigurator->import(SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION);
