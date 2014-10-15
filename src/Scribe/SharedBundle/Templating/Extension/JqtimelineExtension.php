<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\SharedBundle\Templating\Helper\Timeline\TimelineInterface;
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
