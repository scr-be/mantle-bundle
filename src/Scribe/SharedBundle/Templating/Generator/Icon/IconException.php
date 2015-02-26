<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Generator\Icon;

use Scribe\SharedBundle\Templating\Generator\Exceptions\TemplatingGeneratorException;

/**
 * Class IconException
 *
 * @package Scribe\SharedBundle\Templating\Generator\Icon
 */
class IconException extends TemplatingGeneratorException
{
    /**
     * Exception code for validation occurring in the incorrect order
     *
     * @type int
     */
    const CODE_INVALID_VALIDATION_ORDER = 52;
}

/* EOF */