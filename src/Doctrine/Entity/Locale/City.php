<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Locale;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;
use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasCountry;
use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasLanguageCollection;

/**
 * Class City
 */
class City extends AbstractEntity
{
    use HasName;
    use HasLanguageCollection;
    use HasCountry;

    /**
     * @var float|null
     */
    protected $latitude;

    /**
     * @var float|null
     */
    protected $longitude;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @return $this
     */
    public function initializeLatitude()
    {
        $this->latitude = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeLongitude()
    {
        $this->longitude = null;

        return $this;
    }

    /**
     * @param float $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return $this
     */
    public function clearLatitude()
    {
        return $this->initializeLatitude();
    }

    /**
     * @return bool
     */
    public function hasLatitude()
    {
        return (bool) ($this->latitude !== null);
    }

    /**
     * @param float $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return $this
     */
    public function clearLongitude()
    {
        return $this->initializeLongitude();
    }

    /**
     * @return bool
     */
    public function hasLongitude()
    {
        return (bool) ($this->longitude !== null);
    }
}

/* EOF */
