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

use Scribe\MantleBundle\Templating\Helper\Timeline\TimelineInterface;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class JqtimelineExtension.
 */
class JqtimelineExtension extends AbstractTwigExtension
{
    /**
     * Initialize the instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->enableOptionHtmlSafe();

        $this->addFunction('timeline', [$this, 'renderTimeline']);
    }

    /**
     * @param TimelineInterface $timeline
     *
     * @return string
     */
    public function renderTimeline(TimelineInterface $timeline)
    {
        return $timeline->render();
    }
}
