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
 * Class HasAlias
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasAlias
{
    /**
     * The alias property
     *
     * @type string
     */
    protected $alias;

    /**
     * Setter for alias property
     *
     * @param string|null $alias the alias string
     * @return $this
     */
    public function setAlias($alias = null)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Getter for alias property
     *
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Checker for alias property
     *
     * @return bool
     */
    public function hasAlias()
    {
        return (bool)$this->getAlias() !== null;
    }

    /**
     * Nullify the alias property
     *
     * @return $this
     */
    public function clearAlias()
    {
        $this->setAlias(null);

        return $this;
    }
}
