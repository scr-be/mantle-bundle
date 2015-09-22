<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Exceptions\Model;

use Scribe\Wonka\Exception\ExceptionInterface;

/**
 * Interface TemplatingGeneratorExtensionInterface.
 */
interface TemplatingGeneratorExtensionInterface extends ExceptionInterface
{
    /**
     * @var string
     */
    const MSG_TEMPLATING_GENERATOR_GENERIC = 'An unknown template generator error occurred.';

    /**
     * @var int
     */
    const CODE_TEMPLATING_GENERATOR_GENERIC = 7000;
}

/* EOF */
