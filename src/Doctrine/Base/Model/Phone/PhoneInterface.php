<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Phone;

use Scribe\MantleBundle\Doctrine\Base\Model\Type\TypeInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\NameInterface;

/**
 * Class PhoneInterface.
 */
interface PhoneInterface extends TypeInterface, NameInterface
{
    /**
     * @param string $number
     *
     * @return $this
     */
    public function setNumber($number);

    /**
     * @return string
     */
    public function getNumber();

    /**
     * @return string
     */
    public function getNumberFormatted();

    /**
     * @param int $extension
     *
     * @return $this
     */
    public function setExtension($extension);

    /**
     * @return int|null
     */
    public function getExtension();

    /**
     * @return bool
     */
    public function hasExtension();

    /**
     * @return $this
     */
    public function clearExtension();
}

/* EOF */
