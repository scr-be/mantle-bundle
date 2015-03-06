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

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Entity\Template\Entity;
use Scribe\MantleBundle\Entity\Template\HasName;

/**
 * Class Icon
 * @package Scribe\MantleBundle\Entity
 */
class IconFamily extends Entity
{
    /**
     * import name and description entity property traits
     */
    use HasName;

    /**
     * @type string
     */
    private $prefix;

    /**
     * @type jsonArray 
     */
    private $requiredClasses;

    /**
     * @type jsonArray 
     */
    private $optionalClasses;

    /**
     * @type jsonArray 
     */
    private $attributes;

    /**
     * @var IconTemplate[]
     */
    private $templates;

    /**
     * @var Icon[] 
     */
    private $icons;

    /**
     * perform any entity setup
     */
    public function __construct() 
    {
        $this->templates = new ArrayCollection;
        $this->icons     = new ArrayCollection;
    }

    /**
     * Support for casting from object type to string type
     * @return string
     */
    public function __toString()
    {
        $this->getName();
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        $this->prefix;
    }

    /**
     * Setter for prefix property 
     *
     * @param string 
     * @return $this
     */
    public function setPrefix($prefix = null)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Setter for requiredClasses property 
     *
     * @param array 
     * @return $this
     */
    public function setRequiredClasses($requiredClasses = null)
    {
        $this->requiredClasses = $requiredClasses;

        return $this;
    }

    /**
     * Getter for requiredClasses property 
     *
     * @return array 
     */
    public function getRequiredClasses()
    {
        return $this->requiredClasses;
    }

    /**
     * Setter for optionalClasses property 
     *
     * @param array 
     * @return $this
     */
    public function setOptionalClasses($optionalClasses = null)
    {
        $this->optionalClasses = $optionalClasses;

        return $this;
    }

    /**
     * Getter for optionalClasses property 
     *
     * @return array 
     */
    public function getOptionalClasses()
    {
        return $this->optionalClasses;
    }

    /**
     * Checker for optionalClasses property 
     *
     * @return array 
     */
    public function hasOptionalClasses()
    {
        return (bool) ($this->optionalClasses !== null);
    }

    /**
     * Setter for attributes property 
     *
     * @param array 
     * @return $this
     */
    public function setAttributes($attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Getter for attributes property 
     *
     * @return array 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Checker for attributes property 
     *
     * @return array 
     */
    public function hasAttributes()
    {
        return (bool) ($this->attributes !== null);
    }

    /**
     * Setter for templates property 
     *
     * @param ArrayCollection 
     * @return $this
     */
    public function setTemplates(ArrayCollection $templates = null)
    {
        $this->templates = $templates;

        return $this;
    }

    /**
     * Getter for templates collection 
     *
     * @return ArrayCollection 
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Checker for templates collection 
     *
     * @return bool
     */
    public function hasTemplates()
    {
        return (bool) ($this->templates()->count() > 0);
    }

    /**
     * Nullify templates collection 
     *
     * @return $this
     */
    public function clearTemplates()
    {
        $this->templates = new ArrayCollection;

        return $this;
    }

    /**
     * Setter for icons collection 
     *
     * @param ArrayCollection 
     * @return $this
     */
    public function setIcons(ArrayCollection $icons = null)
    {
        $this->icons = $icons;

        return $this;
    }

    /**
     * Getter for icons collection 
     *
     * @return ArrayCollection 
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * Checker for icons collection 
     *
     * @return bool
     */
    public function hasIcons()
    {
        return (bool) ($this->icons() > 0); 
    }

    /**
     * Nullify icons collection 
     *
     * @return $this
     */
    public function clearIcons()
    {
        $this->icons = new ArrayCollection;

        return $this;
    }
}

/* EOF */
