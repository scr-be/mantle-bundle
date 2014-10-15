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

use Scribe\SharedBundle\Templating\Helper\Highcharts\Highchart;
use Scribe\SharedBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Twig_Extension;

/**
 * Class HighchartExtension
 */
class HighchartExtension extends Twig_Extension
{
    use SimpleExtensionTrait;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->init('chart');
    }

    /**
     * @param Highchart $chart
     * @return string
     */
    public function chart(Highchart $chart)
    {
        return $chart->render();
    }
}
