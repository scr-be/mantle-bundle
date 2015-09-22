<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Twig\Extension\Options;

/**
 * Class OptionsDefinitionInterface.
 */
interface OptionsDefinitionInterface
{
    /**
     * @var array
     */
    const OPTION_SAFE_HTML = ['is_safe' => ['html']];

    /**
     * @var array
     */
    const OPTION_SAFE_NONE = ['is_safe' => []];

    /**
     * @var array
     */
    const OPTION_TWIG_ENV_ENABLE = ['needs_environment' => true];

    /**
     * @var array
     */
    const OPTION_TWIG_ENV_DISABLE = ['needs_environment' => false];
}

/* EOF */
