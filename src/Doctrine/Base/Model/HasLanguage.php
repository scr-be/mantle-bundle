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

use Scribe\MantleBundle\Doctrine\Entity\Locale\LanguageName;

/**
 * Class HasLanguage.
 */
trait HasLanguage
{
    /**
     * @var LanguageName
     */
    protected $language;

    /**
     * @return $this
     */
    public function initializeLanguage()
    {
        $this->language = null;

        return $this;
    }

    /**
     * @param LanguageName $language
     *
     * @return $this
     */
    public function setLanguage(LanguageName $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return LanguageName
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return bool
     */
    public function hasLanguage()
    {
        return (bool) ($this->language !== null);
    }

    /**
     * @return $this
     */
    public function clearLanguage()
    {
        return $this->initializeLanguage();
    }
}

/* EOF */
