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
 * Class HasAttributes.
 */
trait HasAttributes
{
    /**
     * The attributes property.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Should be called from constructor of entity using this trait.
     *
     * @return $this
     */
    public function initializeAttributes()
    {
        $this->attributes = [];

        return $this;
    }

    /**
     * Setter for attributes property.
     *
     * @param array|null $attributes array of attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Getter for attributes property.
     *
     * @return array|null
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Checker for attributes property.
     *
     * @return bool
     */
    public function hasAttributes()
    {
        return (bool) (count((array) $this->getAttributes()) > 0);
    }

    /**
     * Check for value in attributes array.
     *
     * @param mixed $value value needle to look for
     *
     * @return bool
     */
    public function hasAttributeValue($value)
    {
        return (bool) (in_array($value, (array) $this->getAttributes()));
    }

    /**
     * Check for key in attributes array.
     *
     * @param string $key key needle to look for
     *
     * @return bool
     */
    public function hasAttributeKey($key)
    {
        return (bool) (array_key_exists($key, (array) $this->getAttributes()));
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
        if ($this->hasAttributeKey($key)) {
            return $this->getAttributes()[$key];
        }

        return null;
    }

    /**
     * Set a key->value attributes property pair.
     *
     * @param string $key       assignment array key
     * @param mixed  $value     new array item value
     * @param bool   $overwrite overwrite a row if the key already exists
     *
     * @return $this
     */
    public function setAttributeValue($key, $value, $overwrite = true)
    {
        $key = (string) $key;

        if ($this->hasAttributeKey($key) !== true || $overwrite === true) {
            $this->attributes[ $key ] = $value;
        }

        return $this;
    }

    /**
     * Nullify the attributes property.
     *
     * @return $this
     */
    public function clearAttributes()
    {
        $this->setAttributes([]);

        return $this;
    }
}

/* EOF */
