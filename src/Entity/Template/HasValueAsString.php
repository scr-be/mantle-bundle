<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Template;

/**
 * Class HasValueAsString
 *
 * @package Scribe\MantleBundle\Entity\Template
 */
trait HasValueAsString
{
    /**
     * The value property
     *
     * @type string
     */
    protected $value;

    /**
     * Setter for value property
     *
     * @param string|null $value the value string
     * @return $this
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Getter for value property
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Checker for value property
     *
     * @return bool
     */
    public function hasValue()
    {
        return (bool) ($this->getValue() !== null);
    }

    /**
     * Nullify the value property
     *
     * @return $this
     */
    public function clearValue()
    {
        $this->setValue(null);

        return $this;
    }
}
