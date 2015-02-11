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
 * Class HasName
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasName
{
    /**
     * The name property
     *
     * @type string
     */
    protected $name;

    /**
     * Setter for name property
     *
     * @param string|null $name the name string
     * @return $this
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Checker for name property
     *
     * @return bool
     */
    public function hasName()
    {
        return (bool) ($this->name !== null);
    }

    /**
     * Nullify the name property
     *
     * @return $this
     */
    public function clearName()
    {
        $this->name = null;

        return $this;
    }
}
