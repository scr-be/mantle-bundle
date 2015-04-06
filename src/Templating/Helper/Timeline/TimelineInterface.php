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

use Datetime;

/**
 * Class TimelineInterface.
 */
interface TimelineInterface
{
    /**
     * @return string
     */
    public function render();

    /**
     * @param int      $id
     * @param string   $name
     * @param Datetime $on
     * @param string   $url
     *
     * @return mixed
     */
    public function addEvent($id, $name, Datetime $on, $url);
}
