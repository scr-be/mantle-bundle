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
 * Class HasAliases.
 */
trait HasAliases
{
    /**
     * The aliases property.
     *
     * @var array
     */
    protected $aliases;

    /**
     * Should be called from constructor of entity using this trait.
     *
     * @return $this
     */
    public function __initAliases()
    {
        $this->aliases = [];

        return $this;
    }

    /**
     * Setter for aliases property.
     *
     * @param array|null $aliases
     *
     * @return $this
     */
    public function setAliases(array $aliases = null)
    {
        $this->aliases = $aliases;

        return $this;
    }

    /**
     * Getter for aliases property.
     *
     * @return string|null
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Checker for aliases property.
     *
     * @return bool
     */
    public function hasAliases()
    {
        return (bool) (is_array($this->aliases) && count($this->aliases) > 0);
    }

    /**
     * Check for a specific alias.
     *
     * @param string $alias
     *
     * @return bool
     */
    public function hasAlias($alias)
    {
        if (false === $this->hasAliases()) {
            return false;
        } elseif (false === array_key_exists($alias, $this->aliases)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $alias
     *
     * @return string|null
     */
    public function getAlias($alias)
    {
        if ($this->hasAlias($alias)) {
            return $this->aliases[$alias];
        }

        return;
    }

    /**
     * Clear the aliases property.
     *
     * @return $this
     */
    public function clearAliases()
    {
        $this->aliases = [];

        return $this;
    }
}

/* EOF */
