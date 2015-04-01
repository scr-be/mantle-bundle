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

/**
 * Class HasVersionAsString.
 */
trait HasVersionAsString
{
    /**
     * The version property.
     *
     * @var string
     */
    protected $version;

    /**
     * Init trait.
     */
    public function initializeVersion()
    {
        $this->version = null;
    }

    /**
     * Setter for version property.
     *
     * @param string|null $version the version integer value
     *
     * @return $this
     */
    public function setVersion($version = null)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Getter for version property.
     *
     * @return string|null
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Checker for version property.
     *
     * @return bool
     */
    public function hasVersion()
    {
        return (bool) ($this->getVersion() !== null);
    }

    /**
     * Nullify the version property.
     *
     * @return $this
     */
    public function clearVersion()
    {
        $this->setVersion(null);

        return $this;
    }
}

/* EOF */
