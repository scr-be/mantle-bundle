<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Icon;

use Scribe\MantleBundle\Templating\Generator\Exceptions\TemplatingGeneratorException;

/**
 * Class IconException.
 */
class IconException extends TemplatingGeneratorException
{
    /**
     * Exception code for validation occurring in the incorrect order.
     *
     * @var int
     */
    const CODE_INVALID_VALIDATION_ORDER = 52;
}

/* EOF */
