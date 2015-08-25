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

use Scribe\MantleBundle\Doctrine\Entity\Locale\Locale;

/**
 * Class HasLocale.
 */
trait HasLocale
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @return $this
     */
    public function initializeLocale()
    {
        $this->locale = null;

        return $this;
    }

    /**
     * @param Locale $locale
     *
     * @return $this
     */
    public function setLocale(Locale $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return bool
     */
    public function hasLocale()
    {
        return (bool) ($this->locale !== null);
    }

    /**
     * @return $this
     */
    public function clearLocale()
    {
        return $this->initializeLocale();
    }
}

/* EOF */
