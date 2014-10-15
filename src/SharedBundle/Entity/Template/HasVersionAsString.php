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
 * Class HasVersionAsString
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasVersionAsString
{
    /**
     * The version property
     *
     * @type string
     */
    protected $version;

    /**
     * Setter for version property
     *
     * @param string|null $version the version integer value
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
     * @return string|null
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
        return (bool)$this->getVersion() !== null;
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
