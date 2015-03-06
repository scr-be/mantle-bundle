<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Template;

use Datetime;

/**
 * Class HasUpdatedOn
 * @package Scribe\MantleBundle\Entity\Template
 */
trait HasUpdatedOn
{
    /**
     * The entity updated_on property
     * @type UpdatedOn
     */
    protected $updated_on;

    /**
     * Setter for updated_on property
     * @param UpdatedOn $updated_on any datetime object instance
     * @return $this
     */
    public function setUpdatedOn(Datetime $updated_on = null)
    {
        $this->updated_on = $updated_on;

        return $this;
    }

    /**
     * Getter (or formatter) for updated_on property
     * @param string|null $format optional string to format updated_on
     * @return UpdatedOn|string|null
     */
    public function getUpdatedOn($format = null)
    {
        if ($format !== null) {
            return $this->updated_on->format($format);
        }

        return $this->updated_on;
    }

    /**
     * Checker for updated_on property
     * @return bool
     */
    public function hasUpdatedOn()
    {
        return (bool)$this->updated_on instanceof Datetime;
    }

    /**
     * Nullify the updated_on property
     * @return $this
     */
    public function clearUpdatedOn()
    {
        $this->updated_on = null;

        return $this;
    }
}

/* EOF */
