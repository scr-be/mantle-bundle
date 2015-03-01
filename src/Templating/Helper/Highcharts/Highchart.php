<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Helper\Highcharts;

use Zend\Json\Json;
use Scribe\Utility\AbstractContainer;

/**
 * Class Highchart
 */
class Highchart extends AbstractContainer
{
    /**
     * graph type: line
     */
    const TYPE_LINE = 'line';

    /**
     * graph type: spline
     */
    const TYPE_SPLINE = 'spline';

    /**
     * graph type: column
     */
    const TYPE_COLUMN = 'column';

    /**
     * graph type: pie
     */
    const TYPE_PIE = 'pie';

    /**
     * graph type: gauge
     */
    const TYPE_GAUGE = 'gauge';

    /**
     * @param string $elementId
     * @param string $type
     * @param mixed $title
     * @param bool $credits
     * @param bool $exporting
     */
    public function __construct($elementId = 'GraphID', $type = self::TYPE_LINE, $title = null, $credits = false, $exporting = false)
    {
        $this->chart = new ChartOption('chart');
        $this->colors = array();
        $this->credits = new ChartOption('credits');
        $this->global = new ChartOption('global');
        $this->labels = new ChartOption('labels');
        $this->lang = new ChartOption('lang');
        $this->legend = new ChartOption('legend');
        $this->loading = new ChartOption('loading');
        $this->plotOptions = new ChartOption('plotOptions');
        $this->point = new ChartOption('point');
        $this->series = array();
        $this->subtitle = new ChartOption('subtitle');
        $this->symbols = array();
        $this->title = new ChartOption('title');
        $this->tooltip = new ChartOption('tooltip');
        $this->xAxis = new ChartOption('xAxis');
        $this->yAxis = new ChartOption('yAxis');

        $this->exporting = new ChartOption('exporting');
        $this->navigation = new ChartOption('navigation');
        $this->pane = new ChartOption('pane');

        $this->chart->renderTo($elementId);
        $this->chart->type($type);
        $this->title->text($title);
        $this->credits->enabled($credits);
        $this->exporting->enabled($exporting);
    }

    /**
     * @param string $key
     * @param array $values
     * @return Highchart
     */
    public function __call($key, $values)
    {
        return $this->setItem($key, $values);
    }

    /**
     * @return string
     */
    public function render()
    {
        $chartJS = "$(function(){\n    var Chart_" . $this->chart->renderTo . " = new Highcharts.Chart({\n";

        // Chart Option
        if (get_object_vars($this->chart->chart)) {
            $chartJS .= "        chart: " .
                Json::encode($this->chart->chart,
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // Pane
        if (get_object_vars($this->pane->pane)) {
            $chartJS .= "        pane: " .
                Json::encode($this->pane->pane,
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // Colors
        if (!empty($this->colors)) {
            $chartJS .= "        colors: " . json_encode($this->colors) . ",\n";
        }

        // Credits
        if (get_object_vars($this->credits->credits)) {
            $chartJS .= "        credits: " . json_encode($this->credits->credits) . ",\n";
        }

        // Exporting
        if (get_object_vars($this->exporting->exporting)) {
            $chartJS .= "        exporting: " .
                Json::encode($this->exporting->exporting,
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // Global
        if (get_object_vars($this->global->global)) {
            $chartJS .= "        global: " . json_encode($this->global->global) . ",\n";
        }

        // Labels
        // Lang

        // Legend
        if (get_object_vars($this->legend->legend)) {
            $chartJS .= "        legend: " .
                Json::encode($this->legend->legend,
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // Loading
        // Navigation
        // Pane

        // PlotOptions
        if (get_object_vars($this->plotOptions->plotOptions)) {
            $chartJS .= "        plotOptions: " .
                Json::encode($this->plotOptions->plotOptions,
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // Series
        if (!empty($this->series)) {
            $chartJS .= "        series: " .
                Json::encode($this->series[0],
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // Subtitle
        if (get_object_vars($this->subtitle->subtitle)) {
            $chartJS .= "        subtitle: " . json_encode($this->subtitle->subtitle) . ",\n";
        }

        // Symbols

        // Title
        if (get_object_vars($this->title->title)) {
            $chartJS .= "        title: " . json_encode($this->title->title) . ",\n";
        }

        // Tooltip
        if (get_object_vars($this->tooltip->tooltip)) {
            $chartJS .= "        tooltip: " .
                Json::encode($this->tooltip->tooltip,
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // xAxis
        if (get_object_vars($this->xAxis->xAxis)) {
            $chartJS .= "        xAxis: " .
                Json::encode($this->xAxis->xAxis,
                    false,
                    array('enableJsonExprFinder' => true)) . ",\n";
        }

        // yAxis
        if (gettype($this->yAxis) === 'array') {
            if (!empty($this->yAxis)) {
                $chartJS .= "        yAxis: " .
                    Json::encode($this->yAxis[0],
                        false,
                        array('enableJsonExprFinder' => true)) . ",\n";
            }
        } elseif (gettype($this->yAxis) === 'object') {
            if (get_object_vars($this->yAxis->yAxis)) {
                $chartJS .= "        yAxis: " .
                    Json::encode($this->yAxis->yAxis,
                        false,
                        array('enableJsonExprFinder' => true)) . ",\n";
            }
        }

        // trim last trailing comma and close parenthesis
        $chartJS = rtrim($chartJS, ",\n") . "\n    });\n});\n";

        return trim($chartJS);
    }
}
