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
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;

/**
 * Class Country;.
 */
class Country extends SlugEntity
{
    use HasName;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var string
     */
    protected $proper;

    /**
     * @var string
     */
    protected $codeA3;

    /**
     * @var int
     */
    protected $codeN;

    /**
     * @param string $proper
     *
     * @return $this
     */
    public function setProper($proper)
    {
        $this->proper = (string) $proper;

        return $this;
    }

    /**
     * @return string
     */
    public function getProper()
    {
        return $this->proper;
    }

    /**
     * @return bool
     */
    public function hasNameProper()
    {
        return (bool) ($this->proper !== null);
    }

    /**
     * @param string $codeA3
     *
     * @return $this
     */
    public function setCodeA3($codeA3)
    {
        $this->codeA3 = (string) $codeA3;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodeA3()
    {
        return $this->codeA3;
    }

    /**
     * @return bool
     */
    public function hasCodeAlpha3()
    {
        return (bool) ($this->codeA3 !== null);
    }

    /**
     * @param int $codeN
     *
     * @return $this
     */
    public function setCodeN($codeN)
    {
        $this->codeN = (int) $codeN;

        return $this;
    }

    /**
     * @return int
     */
    public function getCodeN()
    {
        return $this->codeN;
    }

    /**
     * @return bool
     */
    public function hasCodeNumeric()
    {
        return (bool) ($this->codeN !== null);
    }
}

/* EOF */
