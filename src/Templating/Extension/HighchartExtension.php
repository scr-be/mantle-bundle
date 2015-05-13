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

use Scribe\MantleBundle\Templating\Helper\Highcharts\Highchart;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class HighchartExtension.
 */
class HighchartExtension extends AbstractTwigExtension
{
    /**
     * Initialize the instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->enableOptionHtmlSafe();

        $this->addFunction('chart', [$this, 'renderHighchart']);
    }

    /**
     * @param Highchart $chart
     *
     * @return string
     */
    public function renderHighchart(Highchart $chart)
    {
        return $chart->render();
    }
}
