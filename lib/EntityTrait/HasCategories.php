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
 * Class HasCategories.
 */
trait HasCategories
{
    /**
     * The categories property.
     *
     * @var array
     */
    protected $categories;

    /**
     * Should be called from constructor of entity using this trait.
     *
     * @return $this
     */
    public function initCategories()
    {
        $this->categories = [];

        return $this;
    }

    /**
     * Setter for categories property.
     *
     * @param array|null $categories
     *
     * @return $this
     */
    public function setCategories(array $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Getter for categories property.
     *
     * @return array|null
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Checker for categories property.
     *
     * @return bool
     */
    public function hasCategories()
    {
        return (bool) (is_array($this->categories) && count($this->categories) > 0);
    }

    /**
     * Check for a specific category.
     *
     * @param string $category
     *
     * @return bool
     */
    public function hasCategory($category)
    {
        if (false === $this->hasCategories()) {
            return false;
        } elseif (false === array_key_exists($category, $this->categories)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $category
     *
     * @return string|null
     */
    public function getCategory($category)
    {
        if ($this->hasCategory($category)) {
            return $this->categories[$category];
        }

        return;
    }

    /**
     * Clear the categories property.
     *
     * @return $this
     */
    public function clearCategories()
    {
        $this->categories = [];

        return $this;
    }
}

/* EOF */
