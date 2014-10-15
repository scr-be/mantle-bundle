<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

use Datetime;

/**
 * Class HasDatetime
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasDatetime
{
    /**
     * The entity datetime property
     * @type Datetime
     */
    protected $datetime;

    /**
     * Setter for datetime property
     * @param Datetime $datetime any datetime object instance
     * @return $this
     */
    public function setDatetime(Datetime $datetime = null)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Getter (or formatter) for datetime property
     * @param string|null $format optional string to format datetime
     * @return Datetime|string|null
     */
    public function getDatetime($format = null)
    {
        if ($format !== null) {
            return $this->datetime->format($format);
        }

        return $this->datetime;
    }

    /**
     * Checker for datetime property
     * @return bool
     */
    public function hasDatetime()
    {
        return (bool)$this->datetime instanceof Datetime;
    }

    /**
     * Nullify the datetime property
     * @return $this
     */
    public function clearDatetime()
    {
        $this->datetime = null;

        return $this;
    }
}
