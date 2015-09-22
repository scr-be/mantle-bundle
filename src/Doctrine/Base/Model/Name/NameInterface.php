<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Name;

/**
 * Class NameInterface.
 */
interface NameInterface
{
    /**
     * Setter for name property.
     *
     * @param string|null $name the name string
     *
     * @return $this
     */
    public function setName($name = null);

    /**
     * Getter for name property.
     *
     * @return string|null
     */
    public function getName();

    /**
     * Checker for name property.
     *
     * @return bool
     */
    public function hasName();

    /**
     * Nullify the name property.
     *
     * @return $this
     */
    public function clearName();
}

/* EOF */
