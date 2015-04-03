<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Logger;

use Psr\Log\LoggerInterface;

/**
 * Interface LoggerCallableInterface.
 */
interface LoggerCallableInterface
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger);

    /**
     * @param string $message
     */
    public function __invoke($message);
}

/* EOF */
