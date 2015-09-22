<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Phone;

use Scribe\Wonka\Utility\Filter\StringFilter;

/**
 * Class HasPhone.
 */
trait HasPhone
{
    /**
     * @var string|null
     */
    protected $number;

    /**
     * @var int|null
     */
    protected $extension;

    /**
     * Initialize trait.
     */
    public function initializePhone()
    {
        $this->number = null;
    }

    /**
     * @param string $number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = StringFilter::parsePhoneString($number);

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return (string) $this->number;
    }

    /**
     * @return string
     */
    public function getNumberFormatted()
    {
        return (string) StringFilter::formatPhoneString($this->number);
    }

    /**
     * @param int $extension
     *
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = preg_replace('#[^0-9]#', '', $extension);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return bool
     */
    public function hasExtension()
    {
        return (bool) ($this->extension !== null);
    }

    /**
     * @return $this
     */
    public function clearExtension()
    {
        $this->extension = null;

        return $this;
    }
}

/* EOF */
