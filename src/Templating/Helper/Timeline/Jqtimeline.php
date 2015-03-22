<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Helper\Timeline;

use Scribe\Utility\AbstractContainer;
use Zend\Json\Expr;
use Zend\Json\Json;
use Datetime;

/**
 * Class Jqtimeline.
 */
class Jqtimeline extends AbstractContainer implements TimelineInterface
{
    /**
     * @var string
     */
    private $target;

    /**
     * @var integer
     */
    private $startYear;

    /**
     * @var integer
     */
    private $endYear;

    /**
     * @var integer
     */
    private $numYears;

    /**
     * @var integer
     */
    private $gap;

    /**
     * @var boolean
     */
    private $showToolTip;

    /**
     * @var integer
     */
    private $groupEventWithinPx;

    /**
     * @param string $target
     * @param null   $startYear
     * @param int    $numYears
     * @param int    $gap
     * @param bool   $showToolTip
     * @param int    $groupEventWithinPx
     */
    public function __construct($target, $startYear = null, $numYears = 1, $gap = 60, $showToolTip = true, $groupEventWithinPx = 5)
    {
        $this->target = $target;
        $this->startYear = $startYear !== null ?
            $startYear : (integer) date('Y')
        ;
        $this->numYears = (integer) $numYears;
        $this->gap = (integer) $gap;
        $this->showToolTip = (boolean) $showToolTip;
        $this->groupEventWithinPx = (integer) $groupEventWithinPx;
        $this->endYear = (integer) date('Y');
    }

    /**
     * @param int      $id
     * @param string   $name
     * @param Datetime $on
     * @param string   $url
     *
     * @return mixed|void
     */
    public function addEvent($id, $name, Datetime $on, $url)
    {
        $event = [
            'id' => $id,
            'name' => htmlentities($name),
            'on' => new Expr('new Date('.$on->format('Y,n,j').')'),
            'url' => $url,
        ];

        $this->setItem(null, $event);
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->numYears = $this->endYear - $this->startYear;
        if ($this->numYears === 0) {
            $this->numYears = 1;
        }

        $js = "var ev = ".Json::encode($this->__toArray(), false, array('enableJsonExprFinder' => true)).";\n\n";

        $js .= "var tl = $('".$this->target."').jqtimeline({\n".
            "\t	events: ev,\n".
            "\t gap:".Json::encode($this->gap).",\n".
            "\t numYears:".Json::encode($this->numYears).",\n".
            "\t startYear:".Json::encode($this->startYear).",\n".
            "\t showToolTip:".Json::encode($this->showToolTip).",\n".
            "\t groupEventWithinPx:".Json::encode($this->groupEventWithinPx).",\n".
            "\t\t click:function(e,event){window.location.href=event.url;}\n".
            "\t }\n".
            "\t );\n";

        return trim($js);
    }
}
