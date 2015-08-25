<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Scribe\MantleBundle\Doctrine\Entity\Locale\Country;

/**
 * Class HasCountry.
 */
trait HasCountry
{
    /**
     * @var Country
     */
    protected $country;

    /**
     * @return $this
     */
    public function initializeCountry()
    {
        $this->country = null;

        return $this;
    }

    /**
     * @param Country $country
     *
     * @return $this
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return bool
     */
    public function hasCountry()
    {
        return (bool) ($this->country !== null);
    }

    /**
     * @return $this
     */
    public function clearCountry()
    {
        return $this->initializeCountry();
    }
}

/* EOF */
