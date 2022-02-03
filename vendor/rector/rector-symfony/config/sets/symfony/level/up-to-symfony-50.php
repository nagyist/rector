<?php

declare (strict_types=1);
namespace RectorPrefix20220203;

use Rector\Symfony\Set\SymfonyLevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonySetList::SYMFONY_50);
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonySetList::SYMFONY_50_TYPES);
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonyLevelSetList::UP_TO_SYMFONY_44);
};
