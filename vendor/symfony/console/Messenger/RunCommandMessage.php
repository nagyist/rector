<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix202507\Symfony\Component\Console\Messenger;

use RectorPrefix202507\Symfony\Component\Console\Exception\RunCommandFailedException;
/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class RunCommandMessage
{
    /**
     * @readonly
     */
    public string $input;
    /**
     * @var bool
     * @readonly
     */
    public bool $throwOnFailure = \true;
    /**
     * @var bool
     * @readonly
     */
    public bool $catchExceptions = \false;
    /**
     * @param bool $throwOnFailure  If the command has a non-zero exit code, throw {@see RunCommandFailedException}
     * @param bool $catchExceptions @see Application::setCatchExceptions()
     */
    public function __construct(string $input, bool $throwOnFailure = \true, bool $catchExceptions = \false)
    {
        $this->input = $input;
        $this->throwOnFailure = $throwOnFailure;
        $this->catchExceptions = $catchExceptions;
    }
    public function __toString() : string
    {
        return $this->input;
    }
}
