<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Translation;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasValue;
use Scribe\MantleBundle\Doctrine\Base\Model\HasLocale;

/**
 * Class TranslationMessage
 */
class TranslationMessage extends AbstractEntity
{
    use HasValue;
    use HasLocale;

    /**
     * @var Translation
     */
    protected $translation;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }

    /**
     * @return $this
     */
    public function initializeTranslation()
    {
        $this->translation = null;

        return $this;
    }

    /**
     * @param Translation $translation
     *
     * @return $this
     */
    public function setTranslation(Translation $translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * @return Translation
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * @return bool
     */
    public function hasTranslation()
    {
        return (bool) ($this->translation !== null);
    }

    /**
     * @return $this
     */
    public function clearTranslation()
    {
        return $this->initializeTranslation();
    }
}

/* EOF */
