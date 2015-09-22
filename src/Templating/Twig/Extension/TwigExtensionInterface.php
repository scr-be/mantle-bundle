<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Twig;

/**
 * Class TwigExtensionInterface.
 */
interface TwigExtensionInterface
{
    /**
     * @var string
     */
    const PROPERTY_PART_OPTION = 'OptionCollection';

    /**
     * @var string
     */
    const PROPERTY_PART_METHOD = 'CallableCollection';
}

/* EOF */
