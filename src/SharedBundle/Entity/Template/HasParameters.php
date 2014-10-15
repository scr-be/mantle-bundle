<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

/**
 * Class HasParameters
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasParameters
{
    /**
     * The entity parameters property
     * @type array
     */
    protected $parameters;

    /**
     * Setter for parameters property
     * @param array|null $parameters array of parameters for entity
     * @return $this
     */
    public function setParameters(array $parameters = null)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Getter for parameters property
     * @return array|null
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Checker for parameters property
     * @return bool
     */
    public function hasParameters()
    {
        return (bool)sizeof((array)$this->parameters) > 0;
    }

    /**
     * Check for value existing in parameters array
     * @param mixed $value needle to look for in parameters array values
     * @return bool
     */
    public function hasParameterValue($value)
    {
        return (bool)in_array($value, (array)$this->parameters);
    }

    /**
     * Check for key existing in parameters array
     * @param string $key needle to look for in parameters array keys
     * @return bool
     */
    public function hasParameterKey($key)
    {
        return (bool)array_key_exists($key, (array)$this->parameters);
    }

    /**
     * Nullify the parameters property
     * @return $this
     */
    public function clearParameters()
    {
        $this->parameters = null;

        return $this;
    }
}
