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
use Scribe\MantleBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Twig_Extension;

/**
 * Class HighchartExtension.
 */
class HighchartExtension extends Twig_Extension
{
    use SimpleExtensionTrait;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->init('chart');
    }

    /**
     * @param Highchart $chart
     *
     * @return string
     */
    public function chart(Highchart $chart)
    {
        return $chart->render();
    }
}
