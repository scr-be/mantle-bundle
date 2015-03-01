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

/**
 * Class SystemLoadHistory
 */
class SystemLoadHistory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

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

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     * @param \DateTime $date
     * @return SystemLoadHistory
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set load01
     * @param float $load01
     * @return SystemLoadHistory
     */
    public function setLoad01($load01)
    {
        $this->load01 = $load01;

        return $this;
    }

    /**
     * Get load01
     * @return float
     */
    public function getLoad01()
    {
        return $this->load01;
    }

    /**
     * Set load05
     * @param float $load05
     * @return SystemLoadHistory
     */
    public function setLoad05($load05)
    {
        $this->load05 = $load05;

        return $this;
    }

    /**
     * Get load05
     * @return float
     */
    public function getLoad05()
    {
        return $this->load05;
    }

    /**
     * Set load15
     * @param float $load15
     * @return SystemLoadHistory
     */
    public function setLoad15($load15)
    {
        $this->load15 = $load15;

        return $this;
    }

    /**
     * Get load15
     * @return float
     */
    public function getLoad15()
    {
        return $this->load15;
    }
}
