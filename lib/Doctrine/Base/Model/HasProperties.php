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
 * Class HasProperties.
 */
trait HasProperties
{
    /**
     * The properties property.
     *
     * @var array
     */
    protected $properties;

    /**
     * Should be called from constructor of entity using this property.
     *
     * @return $this
     */
    public function initializeProperties()
    {
        $this->properties = [];

        return $this;
    }

    /**
     * Setter for properties property.
     *
     * @param array|null $properties array of properties
     *
     * @return $this
     */
    public function setProperties(array $properties = null)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * Getter for properties property.
     *
     * @return array|null
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Checker for properties property.
     *
     * @return bool
     */
    public function hasProperties()
    {
        return (bool) (count((array) $this->getProperties()) > 0);
    }

    /**
     * Check for value in properties array.
     *
     * @param mixed $value value needle to look for
     *
     * @return bool
     */
    public function hasPropertyValue($value)
    {
        return (bool) (in_array($value, (array) $this->getProperties()));
    }

    /**
     * Check for key in properties array.
     *
     * @param string $key key needle to look for
     *
     * @return bool
     */
    public function hasPropertyKey($key)
    {
        return (bool) (array_key_exists($key, (array) $this->getProperties()));
    }

    /**
     * Retrieve a single property array value.
     *
     * @param string $key the array key to get the value of
     *
     * @return string|null
     */
    public function getPropertyValue($key)
    {
        if ($this->hasPropertyKey($key)) {
            return $this->getProperties()[$key];
        }

        return;
    }

    /**
     * Set a key->value properties property pair.
     *
     * @param string $key       assignment array key
     * @param mixed  $value     new array item value
     * @param bool   $overwrite overwrite a row if the key already exists
     *
     * @return $this
     */
    public function setPropertyValue($key, $value, $overwrite = true)
    {
        $key = (string) $key;

        if ($this->hasPropertyKey($key) !== true || $overwrite === true) {
            $this->properties[ $key ] = $value;
        }

        return $this;
    }

    /**
     * Nullify the properties property.
     *
     * @return $this
     */
    public function clearProperties()
    {
        $this->setProperties([]);

        return $this;
    }
}

/* EOF */
