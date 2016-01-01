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

use Scribe\Doctrine\ORM\Mapping\UuidEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\HasValue;
use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasLocale;

/**
 * Class TranslationMessage
 */
class TranslationMessage extends UuidEntity
{
    use HasValue;
    use HasLocale;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

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
        $this->translation = null;

        return $this;
    }
}

/* EOF */
