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

use Scribe\Doctrine\ORM\Mapping\UuidEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;
use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasCountry;
use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasLanguageCollection;

/**
 * Class City.
 */
class City extends UuidEntity
{
    use HasName;
    use HasLanguageCollection;
    use HasCountry;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

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
        $this->latitude = null;

        return $this;
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
        $this->longitude = null;

        return $this;
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
