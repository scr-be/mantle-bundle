<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Locale;

use Scribe\MantleBundle\Doctrine\Entity\Locale\City;

/**
 * Class HasCity.
 */
trait HasCity
{
    /**
     * @var City
     */
    protected $city;

    /**
     * @return $this
     */
    public function initializeCity()
    {
        $this->city = null;

        return $this;
    }

    /**
     * @param City $city
     *
     * @return $this
     */
    public function setCity(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return bool
     */
    public function hasCity()
    {
        return (bool) ($this->city !== null);
    }

    /**
     * @return $this
     */
    public function clearCity()
    {
        return $this->initializeCity();
    }
}

/* EOF */
