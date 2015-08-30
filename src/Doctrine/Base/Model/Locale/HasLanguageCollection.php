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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Doctrine\Entity\Locale\LanguageName;

/**
 * Class HasLanguageCollection.
 */
trait HasLanguageCollection
{
    /**
     * @var ArrayCollection|LanguageName[]
     */
    protected $languageCollection;

    /**
     * @return $this
     */
    public function initializeLanguageCollection()
    {
        $this->languageCollection = null;

        return $this;
    }

    /**
     * @param ArrayCollection|LanguageName[] $languageCollection
     *
     * @return $this
     */
    public function setLanguageCollection(ArrayCollection $languageCollection)
    {
        $this->languageCollection = $languageCollection;

        return $this;
    }

    /**
     * @return ArrayCollection|LanguageName[]
     */
    public function getLanguageCollection()
    {
        return $this->languageCollection;
    }

    /**
     * @return bool
     */
    public function hasLanguageCollection()
    {
        return (bool) ($this->languageCollection !== null);
    }

    /**
     * @return $this
     */
    public function clearLanguageCollection()
    {
        return $this->initializeLanguageCollection();
    }
}

/* EOF */
