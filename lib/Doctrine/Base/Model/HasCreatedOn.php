<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model;

use Datetime;

/**
 * Class HasCreatedOn.
 */
trait HasCreatedOn
{
    /**
     * The entity created_on property.
     *
     * @var Datetime
     */
    protected $created_on;

    /**
     * Init trait
     */
    public function initializeCreatedOn()
    {
        $this->created_on = null;
    }

    /**
     * Setter for created_on property.
     *
     * @param Datetime $created_on any datetime object instance
     *
     * @return $this
     */
    public function setCreatedOn(Datetime $created_on = null)
    {
        $this->created_on = $created_on;

        return $this;
    }

    /**
     * Getter (or formatter) for created_on property.
     *
     * @param string|null $format optional string to format created_on
     *
     * @return Datetime|string|null
     */
    public function getCreatedOn($format = null)
    {
        if ($format !== null) {
            return $this->created_on->format($format);
        }

        return $this->created_on;
    }

    /**
     * Checker for created_on property.
     *
     * @return bool
     */
    public function hasCreatedOn()
    {
        return (bool) $this->created_on instanceof Datetime;
    }

    /**
     * Nullify the created_on property.
     *
     * @return $this
     */
    public function clearCreatedOn()
    {
        $this->created_on = null;

        return $this;
    }
}

/* EOF */
