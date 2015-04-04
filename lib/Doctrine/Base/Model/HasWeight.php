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
trait HasWeight
{
    /**
     * @var int
     */
    private $weight;

    /**
     * Init trait.
     */
    public function initializeWeight()
    {
        $this->weight = null;
    }

    /**
     * Set weight.
     *
     * @param int $weight
     *
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Checker for weight
     *
     * @return bool
     */
    public function hasWeight()
    {
        return (bool) ($this->weight !== null);
    }

    /**
     * Clear weight
     *
     * @return $this
     */
    public function clearWeight()
    {
        $this->weight = null;

        return $this;
    }
}

/* EOF */
