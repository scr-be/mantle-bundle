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

/**
 * Class HasDescription.
 */
trait HasDescription
{
    /**
     * The entity description property.
     *
     * @var string
     */
    protected $description;

    /**
     * Init trait
     */
    protected function initDescription()
    {
        $this->description = null;
    }

    /**
     * Setter for description property.
     *
     * @param string|null $description description for entity
     *
     * @return $this
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Getter for description property.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Checker for description property.
     *
     * @return bool
     */
    public function hasDescription()
    {
        return (bool) ($this->description !== null);
    }

    /**
     * Nullify the description property.
     *
     * @return $this
     */
    public function clearDescription()
    {
        $this->description = null;

        return $this;
    }
}

/* EOF */
