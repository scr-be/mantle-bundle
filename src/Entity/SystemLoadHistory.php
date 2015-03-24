<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity;

use Scribe\Entity\AbstractEntity;
use Scribe\EntityTrait\HasDate;

/**
 * Class SystemLoadHistory.
 */
class SystemLoadHistory extends AbstractEntity
{
    use HasDate;

    /**
     * @var float
     */
    private $load01;

    /**
     * @var float
     */
    private $load05;

    /**
     * @var float
     */
    private $load15;

    public function __toString()
    {
        return __CLASS__.'::id('.$this->id.')';
    }

    /**
     * Set load01.
     *
     * @param float $load01
     *
     * @return SystemLoadHistory
     */
    public function setLoad01($load01)
    {
        $this->load01 = $load01;

        return $this;
    }

    /**
     * Get load01.
     *
     * @return float
     */
    public function getLoad01()
    {
        return $this->load01;
    }

    /**
     * Set load05.
     *
     * @param float $load05
     *
     * @return SystemLoadHistory
     */
    public function setLoad05($load05)
    {
        $this->load05 = $load05;

        return $this;
    }

    /**
     * Get load05.
     *
     * @return float
     */
    public function getLoad05()
    {
        return $this->load05;
    }

    /**
     * Set load15.
     *
     * @param float $load15
     *
     * @return SystemLoadHistory
     */
    public function setLoad15($load15)
    {
        $this->load15 = $load15;

        return $this;
    }

    /**
     * Get load15.
     *
     * @return float
     */
    public function getLoad15()
    {
        return $this->load15;
    }
}

/* EOF */
