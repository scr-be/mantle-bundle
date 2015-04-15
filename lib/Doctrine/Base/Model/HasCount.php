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
 * Class HasCount.
 */
trait HasCount
{
    /**
     * The count property.
     *
     * @var int|null
     */
    protected $count;

    /**
     * Init trait.
     */
    public function initializeCount()
    {
        $this->count = null;
    }

    /**
     * Setter for count property.
     *
     * @param int|null $count the integer number
     *
     * @return $this
     */
    public function setCount($count = null)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Getter for count property.
     *
     * @return int|null
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Checker for count property.
     *
     * @return bool
     */
    public function hasCount()
    {
        return (bool) is_int($this->getCount());
    }

    /**
     * Nullify the count property.
     *
     * @return $this
     */
    public function clearCount()
    {
        $this->setCount(null);

        return $this;
    }

    /**
     * Increment the counter.
     *
     * @param int $by number to increment the count by
     *
     * @return $this
     */
    public function incrementCount($by = 1)
    {
        $this->setCount(
            $this->getCount() + $by
        );

        return $this;
    }

    /**
     * Decrement the counter.
     *
     * @param int $by number to decrement the count by
     *
     * @return $this
     */
    public function decrementCount($by = 1)
    {
        $this->setCount(
            $this->getCount() - $by
        );

        return $this;
    }
}

/* EOF */
