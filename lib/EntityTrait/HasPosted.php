<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\EntityTrait;

use DateTime;

/**
 * Class HasPosted.
 */
trait HasPosted
{
    /**
     * @var Datetime
     */
    private $posted;

    /**
     * Init trait
     */
    public function __initPosted()
    {
        $this->posted = null;
    }

    /**
     * @return Datetime
     */
    public function getPosted()
    {
        return $this->posted;
    }

    /**
     * @param DateTime $datetime
     *
     * @return $this
     */
    public function setPosted(DateTime $datetime)
    {
        $this->posted = $datetime;

        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getPostedFormatted($format = 'r')
    {
        return $this->getPosted()->format($format);
    }
}

/* EOF */
