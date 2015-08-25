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
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\Description\HasDescription;
use Scribe\Doctrine\Base\Model\Name\HasName;
use Scribe\Doctrine\Base\Model\HasSlug;

/**
 * Class LanguageFamily;
 */
class LanguageFamily extends AbstractEntity
{
    use HasSlug;
    use HasName;
    use HasDescription;

    /**
     * @var LanguageName[]|ArrayCollection
     */
    protected $languageCollection;

    /**
     * @var string|null
     */
    protected $src;

    /**
     * @return $this
     */
    public function initializeLanguageCollection()
    {
        $this->languageCollection = new ArrayCollection;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeSrc()
    {
        $this->src = null;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $src
     *
     * @return $this
     */
    public function setSrc($src)
    {
        $this->src = $src;

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
