<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

/**
 * Class HasPersonSuffix.
 */
trait HasPersonSuffix
{
    /**
     * The suffix property.
     *
     * @var string
     */
    protected $suffix;

    /**
     * Init trait.
     */
    public function initializeSuffix()
    {
        $this->suffix = null;
    }

    /**
     * Setter for suffix property.
     *
     * @param string|null $suffix the suffix string
     *
     * @return $this
     */
    public function setSuffix($suffix = null)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Getter for suffix property.
     *
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Checker for suffix property.
     *
     * @return bool
     */
    public function hasSuffix()
    {
        return (bool) ($this->getSuffix() !== null);
    }

    /**
     * Nullify the suffix property.
     *
     * @return $this
     */
    public function clearSuffix()
    {
        $this->setSuffix(null);

        return $this;
    }
}

/* EOF */
