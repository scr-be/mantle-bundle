<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Helper\Timeline;

use Scribe\Utility\AbstractContainer;
use Zend\Json\Expr;
use Zend\Json\Json;

/**
 * Class Jqtimeline
 */
class Chronoline extends AbstractContainer
{
    /**
     * @var string
     */
    private $target;

    /**
     * @param string $target
     */
    public function __construct($target, $events = [])
    {
        $this->target = $target;
        foreach ($events as $e) {
            $this->addEvent($e);
        }
    }

    /**
     * @return mixed|void
     */
    public function addEvent($event)
    {
        $dates = [];
        if (!isset($event['dates'])) {
            return;
        }
        foreach ($event['dates'] as $d) {
            $dates[] = new Expr('new Date('.$d->format('Y,n,j').')');
        }
        $item = [
            'dates' => $dates,
            'title' => $event['title'],
            'description' => (isset($event['description']) ? $event['description'] : null),
        ];

        $this->setItem(null, $item);
    }

    /**
     * @return string
     */
    public function render()
    {
        $js = "var chronolineEvents = ".Json::encode($this->__toArray(), false, array('enableJsonExprFinder' => true)).";\n\n";

        $js .= 'var timeline = new Chronoline(document.getElementById("'.$this->target.'"), chronolineEvents,'."\n".
            "\t".'{'."\n".
            "\t\t".'visibleSpan: DAY_IN_MILLISECONDS * 366,'."\n".
            "\t\t".'labelInterval: isHalfMonth,'."\n".
            "\t\t".'hashInterval: isHalfMonth,'."\n".
            "\t\t".'scrollLeft: prevMonth,'."\n".
            "\t\t".'scrollRight: nextMonth,'."\n".
            "\t\t".'animated: true,'."\n".
            "\t\t".'tooltips: true'."\n".
            //"\t\t".'defaultStartDate: '.new Expr('new Date('.(new \Datetime)->format('Y,n,j').')')."\n".
            "\t".'}'."\n".
            ');'."\n";

        return trim($js);
    }
}
