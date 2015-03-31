<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model;

/**
 * Class HasTraits.
 */
trait HasTraits
{
    /**
     * The traits property.
     *
     * @var array
     */
    protected $traits;

    /**
     * Init trait
     */
    public function initializeTraits()
    {
        $this->traits = [];
    }

    /**
     * Setter for traits property.
     *
     * @param array|null $traits array of traits
     *
     * @return $this
     */
    public function setTraits(array $traits = null)
    {
        $this->traits = $traits;

        return $this;
    }

    /**
     * Getter for traits property.
     *
     * @return array|null
     */
    public function getTraits()
    {
        return $this->traits;
    }

    /**
     * Checker for traits property.
     *
     * @return bool
     */
    public function hasTraits()
    {
        return (bool) sizeof((array) $this->getTraits()) > 0;
    }

    /**
     * Check for value in traits array.
     *
     * @param mixed $value value needle to look for
     *
     * @return bool
     */
    public function hasTraitsValue($value)
    {
        return (bool) in_array($value, (array) $this->getTraits());
    }

    /**
     * Check for key in traits array.
     *
     * @param string $key key needle to look for
     *
     * @return bool
     */
    public function hasTraitsKey($key)
    {
        return (bool) array_key_exists($key, (array) $this->getTraits());
    }

    /**
     * Retrieve a single attribute array value.
     *
     * @param string $key the array key to get the value of
     *
     * @return string|null
     */
    public function getAttributeValue($key)
    {
        if ($this->hasTraitsKey($key)) {
            return $this->getTraits()[$key];
        }

        return;
    }

    /**
     * Set a key->value traits property pair.
     *
     * @param string $key       assignment array key
     * @param mixed  $value     new array item value
     * @param bool   $overwrite overwrite a row if the key already exists
     *
     * @return $this
     */
    public function setTraitsValue($key, $value, $overwrite = true)
    {
        $key = (string) $key;

        if ($this->hasTraitsKey($key) !== true || $overwrite === true) {
            $this->getTraits()[ $key ] = $value;
        }

        return $this;
    }

    /**
     * Nullify the traits property.
     *
     * @return $this
     */
    public function clearTraits()
    {
        $this->setTraits(null);

        return $this;
    }
}

/* EOF */
