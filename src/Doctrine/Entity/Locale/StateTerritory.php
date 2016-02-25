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

use Scribe\Doctrine\ORM\Mapping\SlugEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasCountry;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;

/**
 * Class StateTerritory.
 */
class StateTerritory extends SlugEntity
{
    use HasCountry;
    use HasName;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var string
     */
    protected $abbr;

    /**
     * @var string
     */
    protected $capital;

    /**
     * @param string $abbr
     *
     * @return $this
     */
    public function setAbbr($abbr)
    {
        $this->abbr = $abbr;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbbr()
    {
        return $this->abbr;
    }

    /**
     * @param string $capital
     *
     * @return $this
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * @return string
     */
    public function getCapital()
    {
        return $this->capital;
    }
}

/* EOF */
