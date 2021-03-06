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
 * Class HasParameters.
 */
trait HasParameters
{
    /**
     * The entity parameters property.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Init trait.
     */
    public function initializeParameters()
    {
        $this->parameters = [];
    }

    /**
     * Setter for parameters property.
     *
     * @param array|null $parameters array of parameters for entity
     *
     * @return $this
     */
    public function setParameters(array $parameters = null)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Getter for parameters property.
     *
     * @return array|null
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Checker for parameters property.
     *
     * @return bool
     */
    public function hasParameters()
    {
        return (bool) sizeof((array) $this->parameters) > 0;
    }

    /**
     * Check for value existing in parameters array.
     *
     * @param mixed $value needle to look for in parameters array values
     *
     * @return bool
     */
    public function hasParameterValue($value)
    {
        return (bool) in_array($value, (array) $this->parameters);
    }

    /**
     * Check for key existing in parameters array.
     *
     * @param string $key needle to look for in parameters array keys
     *
     * @return bool
     */
    public function hasParameterKey($key)
    {
        return (bool) array_key_exists($key, (array) $this->parameters);
    }

    /**
     * Retrieve a single parameter array value.
     *
     * @param string $key the array key to get the value of
     *
     * @return string|null
     */
    public function getParameterValue($key)
    {
        if ($this->hasParameterKey($key)) {
            return $this->getParameters()[$key];
        }

        return;
    }

    /**
     * Set a key->value parameters property pair.
     *
     * @param string $key       assignment array key
     * @param mixed  $value     new array item value
     * @param bool   $overwrite overwrite a row if the key already exists
     *
     * @return $this
     */
    public function setParameterValue($key, $value, $overwrite = true)
    {
        $key = (string) $key;

        if ($this->hasParameterKey($key) !== true || $overwrite === true) {
            $this->parameters[ $key ] = $value;
        }

        return $this;
    }

    /**
     * Nullify the parameters property.
     *
     * @return $this
     */
    public function clearParameters()
    {
        $this->parameters = null;

        return $this;
    }
}

/* EOF */
