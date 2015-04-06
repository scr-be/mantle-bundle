<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node;

use Scribe\MantleBundle\Templating\Generator\Exceptions\TemplatingGeneratorException;

/**
 * Class NodeException.
 */
class NodeException extends TemplatingGeneratorException
{
    /**
     * Exception code for an unknown/missing service.
     *
     * @var int
     */
    const CODE_MISSING_SERVICE = 201;
}

/* EOF */
