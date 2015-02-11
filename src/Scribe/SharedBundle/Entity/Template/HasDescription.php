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

/**
 * Class HasDescription
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasDescription
{
    /**
     * The entity description property
     * @type string
     */
    protected $description;

    /**
     * Setter for description property
     * @param string|null $description description for entity
     * @return $this
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Getter for description property
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Checker for description property
     * @return bool
     */
    public function hasDescription()
    {
        return (bool) ($this->description !== null);
    }

    /**
     * Nullify the description property
     * @return $this
     */
    public function clearDescription()
    {
        $this->description = null;

        return $this;
    }
}
