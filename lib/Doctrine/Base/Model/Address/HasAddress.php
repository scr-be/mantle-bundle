<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Address;

/**
 * Class HasAddress.
 */
trait HasAddress
{
    /**
     * @var string
     */
    protected $address01;

    /**
     * @var string|null
     */
    protected $address02;

    /**
     * @var string|null
     */
    protected $address03;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $zip;

    /**
     * Initialize trait.
     */
    public function initializeAddress()
    {
        $this->address01 = null;
        $this->address02 = null;
        $this->address03 = null;
        $this->city = null;
        $this->state = null;
        $this->zip = null;
    }

    /**
     * @param string $address01
     *
     * @return $this
     */
    public function setAddress01($address01)
    {
        $this->address01 = $address01;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress01()
    {
        return $this->address01;
    }

    /**
     * @param string|null $address02
     *
     * @return $this
     */
    public function setAddress02($address02 = null)
    {
        $this->address02 = $address02;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress02()
    {
        return $this->address02;
    }

    /**
     * @return bool
     */
    public function hasAddress02()
    {
        return (bool) (is_string($this->address02) && strlen($this->address02) > 0);
    }

    /**
     * @param string|null $address03
     *
     * @return $this
     */
    public function setAddress03($address03 = null)
    {
        $this->address03 = $address03;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress03()
    {
        return $this->address03;
    }

    /**
     * @return bool
     */
    public function hasAddress03()
    {
        return (bool) (is_string($this->address03) && strlen($this->address03) > 0);
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $zip
     *
     * @return $this
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }
}

/* EOF */
