<?php

declare (strict_types=1);
namespace Rector\Symfony\Enum;

final class SymfonyClass
{
    /**
     * @var string
     */
    public const CONTROLLER = 'Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller';
    /**
     * @var string
     */
    public const RESPONSE = 'Symfony\\Component\\HttpFoundation\\Response';
    /**
     * @var string
     */
    public const COMMAND = 'Symfony\\Component\\Console\\Command\\Command';
    /**
     * @var string
     */
    public const CONTAINER_AWARE_COMMAND = 'Symfony\\Bundle\\FrameworkBundle\\Command\\ContainerAwareCommand';
}
