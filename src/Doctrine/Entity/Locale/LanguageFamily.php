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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\ORM\Mapping\SlugEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;

/**
 * Class LanguageFamily;.
 */
class LanguageFamily extends SlugEntity
{
    use HasName;
    use HasDescription;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var LanguageName[]|ArrayCollection
     */
    protected $languageCollection;

    /**
     * @var string|null
     */
    protected $referenceUrl;

    /**
     * @return $this
     */
    public function initializeLanguageCollection()
    {
        $this->languageCollection = new ArrayCollection();

        return $this;
    }

    /**
     * @return null|string
     */
    public function getReferenceUrl()
    {
        return $this->referenceUrl;
    }

    /**
     * @param string $referenceUrl
     *
     * @return $this
     */
    public function setReferenceUrl($referenceUrl)
    {
        $this->referenceUrl = $referenceUrl;

        return $this;
    }

    /**
     * @return LanguageName[]|ArrayCollection
     */
    public function getLanguageCollection()
    {
        return $this->languageCollection;
    }

    /**
     * @param LanguageName $language
     *
     * @return bool
     */
    public function hasLanguage(LanguageName $language)
    {
        return (bool) ($this->languageCollection->contains($language));
    }
}

/* EOF */
