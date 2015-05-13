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

use Scribe\MantleBundle\Templating\Helper\Timeline\Chronoline;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class ChronolineExtension.
 */
class ChronolineExtension extends AbstractTwigExtension
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->enableOptionHtmlSafe();

        $this->addFunction('chronoline', [$this, 'renderChronoline']);
    }

    /**
     * @return string
     */
    public function renderChronoline(Chronoline $chronoline)
    {
        return $chronoline->render();
    }
}
