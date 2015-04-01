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
 * Class HasAlias.
 */
trait HasAlias
{
    /**
     * The alias property.
     *
     * @var string
     */
    protected $alias;

    /**
     * Init trait.
     */
    public function initializeAlias()
    {
        $this->alias = null;
    }

    /**
     * Setter for alias property.
     *
     * @param string|null $alias the alias string
     *
     * @return $this
     */
    public function setAlias($alias = null)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Getter for alias property.
     *
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Checker for alias property.
     *
     * @return bool
     */
    public function hasAlias()
    {
        return (bool) ($this->getAlias() !== null);
    }

    /**
     * Nullify the alias property.
     *
     * @return $this
     */
    public function clearAlias()
    {
        $this->setAlias(null);

        return $this;
    }
}

/* EOF */
