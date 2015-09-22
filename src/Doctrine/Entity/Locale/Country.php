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

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\HasCode;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;

/**
 * Class Country;
 */
class Country extends AbstractEntity
{
    use HasName;
    use HasCode;

    /**
     * @var string
     */
    protected $nameProper;

    /**
     * @var string
     */
    protected $codeAlpha3;

    /**
     * @var int
     */
    protected $codeNumeric;

    /**
     * @param string $nameProper
     *
     * @return $this
     */
    public function setNameProper($nameProper)
    {
        $this->nameProper = (string) $nameProper;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameProper()
    {
        return $this->nameProper;
    }

    /**
     * @return bool
     */
    public function hasNameProper()
    {
        return (bool) ($this->nameProper !== null);
    }

    /**
     * @param string $codeAlpha3
     *
     * @return $this
     */
    public function setCodeAlpha3($codeAlpha3)
    {
        $this->codeAlpha3 = (string) $codeAlpha3;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodeAlpha3()
    {
        return $this->codeAlpha3;
    }

    /**
     * @return bool
     */
    public function hasCodeAlpha3()
    {
        return (bool) ($this->codeAlpha3 !== null);
    }

    /**
     * @param int $codeNumeric
     *
     * @return $this
     */
    public function setCodeNumeric($codeNumeric)
    {
        $this->codeNumeric = (int) $codeNumeric;

        return $this;
    }

    /**
     * @return int
     */
    public function getCodeNumeric()
    {
        return $this->codeNumeric;
    }

    /**
     * @return bool
     */
    public function hasCodeNumeric()
    {
        return (bool) ($this->codeNumeric !== null);
    }
}

/* EOF */
