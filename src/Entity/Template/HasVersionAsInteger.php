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

/**
 * Class HasVersionAsInteger
 *
 * @package Scribe\MantleBundle\Entity\Template
 */
trait HasVersionAsInteger
{
    /**
     * The version property
     *
     * @type int
     */
    protected $version;

    /**
     * Setter for version property
     *
     * @param int|null $version the version integer value
     * @return $this
     */
    public function setVersion($version = null)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Getter for version property
     *
     * @return int|null
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Checker for version property
     *
     * @return bool
     */
    public function hasVersion()
    {
        return (bool) ($this->getVersion() !== null);
    }

    /**
     * Nullify the version property
     *
     * @return $this
     */
    public function clearVersion()
    {
        $this->setVersion(null);

        return $this;
    }
}
