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

use Scribe\Doctrine\ORM\Mapping\IdEntity;
use Scribe\Doctrine\ORM\Mapping\SlugEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\HasAliases;
use Scribe\MantleBundle\Doctrine\Base\Model\HasCode;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;

/**
 * Class Locale;
 */
class LanguageName extends SlugEntity
{
    use HasName;
    use HasCode;
    use HasAliases;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var LanguageFamily
     */
    protected $family;

    /**
     * @var string
     */
    protected $codeA3;

    /**
     * @var array|null
     */
    protected $nativeNames;

    /**
     * @return $this
     */
    public function initializeNativeNames()
    {
        $this->nativeNames = [];

        return $this;
    }

    /**
     * @param LanguageFamily $family
     *
     * @return $this
     */
    public function setFamily(LanguageFamily $family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * @return LanguageFamily
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param string $codeA3
     *
     * @return $this
     */
    public function setCodeA3($codeA3)
    {
        $this->codeA3 = $codeA3;

        return $this;
    }

    /**]
     * @return string|null
     */
    public function getCodeA3()
    {
        return $this->codeA3;
    }

    /**
     * @return $this
     */
    public function clearCodeA3()
    {
        $this->codeA3 = null;

        return $this;
    }

    /**
     * @return bool
     */
    public function hadCodeA3()
    {
        return (bool) ($this->codeA3 !== null);
    }

    /**
     * @param array $nativeNames
     *
     * @return $this
     */
    public function setNativeNames(array $nativeNames = null)
    {
        $this->nativeNames = $nativeNames;

        return $this;
    }

    /**
     * @return array
     */
    public function getNativeNames()
    {
        return $this->nativeNames;
    }

    /**
     * @return $this
     */
    public function cleanNativeNames()
    {
        return $this->initializeNativeNames();
    }

    /**
     * @return bool
     */
    public function hadNativeNames()
    {
        return (bool) ($this->nativeNames !== null || count($this->nativeNames) > 0);
    }
}

/* EOF */
