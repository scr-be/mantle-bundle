<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\EntityTrait;

/**
 * Class HasAttrs.
 */
trait HasAttrs
{
    /**
     * The attrs property.
     *
     * @var array
     */
    protected $attrs;

    /**
     * Should be called from constructor of entity using this trait.
     *
     * @return $this
     */
    public function __initAttrs()
    {
        $this->attrs = [];

        return $this;
    }

    /**
     * Setter for attrs property.
     *
     * @param array|null $attrs array of attrs
     *
     * @return $this
     */
    public function setAttrs(array $attrs = null)
    {
        $this->attrs = $attrs;

        return $this;
    }

    /**
     * Getter for attrs property.
     *
     * @return array|null
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * Checker for attrs property.
     *
     * @return bool
     */
    public function hasAttrs()
    {
        return (bool) (count((array) $this->getAttrs()) > 0);
    }

    /**
     * Check for value in attrs array.
     *
     * @param mixed $value value needle to look for
     *
     * @return bool
     */
    public function hasAttrValue($value)
    {
        return (bool) (in_array($value, (array) $this->getAttrs()));
    }

    /**
     * Check for key in attrs array.
     *
     * @param string $key key needle to look for
     *
     * @return bool
     */
    public function hasAttrKey($key)
    {
        return (bool) (array_key_exists($key, (array) $this->getAttrs()));
    }

    /**
     * Retrieve a single attr array value.
     *
     * @param string $key the array key to get the value of
     *
     * @return string|null
     */
    public function getAttrValue($key)
    {
        if ($this->hasAttrKey($key)) {
            return $this->getAttrs()[$key];
        }

        return;
    }

    /**
     * Set a key->value attrs property pair.
     *
     * @param string $key       assignment array key
     * @param mixed  $value     new array item value
     * @param bool   $overwrite overwrite a row if the key already exists
     *
     * @return $this
     */
    public function setAttrValue($key, $value, $overwrite = true)
    {
        $key = (string) $key;

        if ($this->hasAttrKey($key) !== true || $overwrite === true) {
            $this->getAttrs()[ $key ] = $value;
        }

        return $this;
    }

    /**
     * Nullify the attrs property.
     *
     * @return $this
     */
    public function clearAttrs()
    {
        $this->setAttrs([]);

        return $this;
    }
}

/* EOF */
