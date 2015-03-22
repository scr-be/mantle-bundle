<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity;

use Scribe\Entity\AbstractEntity;
use Scribe\EntityTrait\HasName;
use Scribe\EntityTrait\HasDescription;
use Scribe\EntityTrait\HasSlug;

/**
 * Class Icon.
 */
class IconTemplate extends AbstractEntity
{
    /*
     * import name and description entity property traits
     */
    use HasName,
        HasSlug,
        HasDescription;

    /**
     * @var array
     */
    private $variables;

    /**
     * @var string
     */
    private $engine;

    /**
     * @var string
     */
    private $template;

    /**
     * @var IconFamily
     */
    private $family;

    /**
     * @var integer
     */
    private $priority;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
    }

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        $this->getName();
    }

    /**
     * Setter for variables property.
     *
     * @param array
     *
     * @return $this
     */
    public function setVariables($variables = null)
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * Getter for variables property.
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Checker for variables property.
     *
     * @return bool
     */
    public function hasVariables()
    {
        return (bool) ($this->getVariables() !== null);
    }

    /**
     * Nullify variables property.
     *
     * @return $this
     */
    public function clearVariables()
    {
        $this->setVariables(null);

        return $this;
    }

    /**
     * Setter for engine property.
     *
     * @param string
     *
     * @return $this
     */
    public function setEngine($engine = null)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Getter for engine property.
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Setter for template property.
     *
     * @param string
     *
     * @return $this
     */
    public function setTemplate($template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Getter for template property.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Setter for family property.
     *
     * @param IconFamily
     *
     * @return $this
     */
    public function setFamily(IconFamily $family = null)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Getter for family property.
     *
     * @return IconFamily
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Checker for family property.
     *
     * @return bool
     */
    public function hasFamily()
    {
        return (bool) ($this->getFamily() !== null);
    }

    /**
     * Nullify family.
     *
     * @return $this
     */
    public function clearFamily()
    {
        $this->family = null;

        return $this;
    }

    /**
     * Setter for priority property.
     *
     * @param integer
     *
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Getter for priority property.
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }
}

/* EOF */
