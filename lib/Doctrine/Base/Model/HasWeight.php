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
     * @var integer
     */
    private $weight;

    /**
     * Init trait
     */
    public function initializeVersion()
    {
        $this->weight = null;
    }

    /**
     * Set weight.
     *
     * @param integer $weight
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
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }
}

/* EOF */
