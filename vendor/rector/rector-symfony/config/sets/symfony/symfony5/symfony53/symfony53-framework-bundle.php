<?php

declare (strict_types=1);
namespace RectorPrefix202507;

use Rector\Config\RectorConfig;
use Rector\Symfony\Symfony53\Rector\StaticPropertyFetch\KernelTestCaseContainerPropertyDeprecationRector;
return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->rules([KernelTestCaseContainerPropertyDeprecationRector::class]);
};
