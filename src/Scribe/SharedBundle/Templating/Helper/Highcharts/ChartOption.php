<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Helper\Highcharts;

use stdClass;

/**
 * Class ChartOption
 */
class ChartOption {

    /**
     * @var string
     */
    private $optionName;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->optionName = $name;
        $this->{$name} = new stdClass();
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function __call($name, $value)
    {
        $this->{$this->optionName}->{$name} = $value[0];

        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$this->optionName}->{$name};
    }
}
