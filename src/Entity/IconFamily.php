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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\EntityTrait\HasAttributes;
use Scribe\EntityTrait\HasIconsOwningSide;
use Scribe\EntityTrait\HasSlug;
use Scribe\EntityTrait\HasName;
use Scribe\EntityTrait\HasVersionAsString;
use Scribe\Entity\AbstractEntity;

/**
 * Class Icon.
 */
class IconFamily extends AbstractEntity
{
    /*
     * import name and description entity property traits
     */
    use HasSlug,
        HasName,
        HasVersionAsString,
        HasAttributes,
        HasIconsOwningSide;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var array
     */
    private $requiredClasses;

    /**
     * @var array
     */
    private $optionalClasses;

    /**
     * @var IconTemplate[]
     */
    private $templates;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        $this->templates = new ArrayCollection();
        $this->icons     = new ArrayCollection();
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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Setter for prefix property.
     *
     * @param string
     *
     * @return $this
     */
    public function setPrefix($prefix = null)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Setter for requiredClasses property.
     *
     * @param array
     *
     * @return $this
     */
    public function setRequiredClasses($requiredClasses = null)
    {
        $this->requiredClasses = $requiredClasses;

        return $this;
    }

    /**
     * Getter for requiredClasses property.
     *
     * @return array
     */
    public function getRequiredClasses()
    {
        return $this->requiredClasses;
    }

    /**
     * @return bool
     */
    public function hasRequiredClasses()
    {
        return (bool) (count($this->requiredClasses) > 0 ? true : false);
    }

    /**
     * Setter for optionalClasses property.
     *
     * @param array
     *
     * @return $this
     */
    public function setOptionalClasses($optionalClasses = null)
    {
        $this->optionalClasses = $optionalClasses;

        return $this;
    }

    /**
     * Getter for optionalClasses property.
     *
     * @return array
     */
    public function getOptionalClasses()
    {
        return $this->optionalClasses;
    }

    /**
     * Checker for optionalClasses property.
     *
     * @return array
     */
    public function hasOptionalClasses()
    {
        return (bool) ($this->optionalClasses !== null);
    }

    /**
     * Setter for templates property.
     *
     * @param ArrayCollection $templates
     *
     * @return $this
     */
    public function setTemplates(ArrayCollection $templates = null)
    {
        $this->templates = $templates;

        return $this;
    }

    /**
     * Getter for templates collection.
     *
     * @return ArrayCollection
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Checker for templates collection.
     *
     * @return bool
     */
    public function hasTemplates()
    {
        return (bool) ($this->getTemplates()->count() > 0);
    }

    /**
     * Nullify templates collection.
     *
     * @return $this
     */
    public function clearTemplates()
    {
        $this->templates = new ArrayCollection();

        return $this;
    }
}

/* EOF */
