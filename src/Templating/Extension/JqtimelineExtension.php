<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Extension;

use Scribe\MantleBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\MantleBundle\Templating\Helper\Timeline\TimelineInterface;
use Twig_Extension;

/**
 * Class JqtimelineExtension
 */
class JqtimelineExtension extends Twig_Extension
{
    use SimpleExtensionTrait;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->init('timeline');
    }

    /**
     * @param TimelineInterface $timeline
     * @return string
     */
    public function timeline(TimelineInterface $timeline)
    {
        return $timeline->render();
    }
}
