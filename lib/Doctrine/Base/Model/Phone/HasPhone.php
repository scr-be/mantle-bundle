<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Phone;

use Scribe\Utility\Filter\StringFilter;

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
        return (string) StringFilter::formatPhoneString($this->number);
    }
}

/* EOF */
