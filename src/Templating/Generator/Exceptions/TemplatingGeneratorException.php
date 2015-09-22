<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Exceptions;

use Scribe\Wonka\Exception\RuntimeException;
use Scribe\MantleBundle\Templating\Generator\Exceptions\Model\TemplatingGeneratorExtensionInterface;

/**
 * Class TemplatingGeneratorException.
 */
class TemplatingGeneratorException extends RuntimeException implements TemplatingGeneratorExtensionInterface
{
    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_TEMPLATING_GENERATOR_GENERIC;
    }

    /**
     * Get the default exception code.
     *
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_TEMPLATING_GENERATOR_GENERIC;
    }
}

/* EOF */
