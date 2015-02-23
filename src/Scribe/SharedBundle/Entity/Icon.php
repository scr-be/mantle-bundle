<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Scribe\SharedBundle\Entity\Template\Entity,
    Scribe\SharedBundle\Entity\Template\HasName,
    Scribe\SharedBundle\Entity\Template\HasDescription;

/**
 * Class Icon
 * @package Scribe\SharedBundle\Entity
 */
class Icon extends Entity
{
    /**
     * import name and description entity property traits
     */
    use HasName,
        HasDescription;

    /**
     * The associated families 
     * @type IconFamilies
     */
    private $families;

    /**
     * @type string
     */
    private $slug;

    /**
     * @var string 
     */
    private $unicode;

    /**
     * @var jsonArray 
     */
    private $aliases;

    /**
     * @var jsonArray 
     */
    private $categories;

    /**
     * perform any entity setup
     */
    public function __construct()
    {
        $this->families = new ArrayCollection;
    }

    /**
     * Support for casting from object type to string type
     * @return string
     */
    public function __toString()
    {
        return $this->getFamilies() . ':' . $this->getName();
    }

    /**
     * Setter for families property
     * @param $families entity
     * @return $this
     */
    public function setFamilies(ArrayCollection $families = null)
    {
        $this->families = $families;

        return $this;
    }

    /**
     * Getter for families property
     * @return IconFamilies 
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * Checker for families property
     * @return bool
     */
    public function hasFamilies()
    {
        return (bool) ($this->families !== null);
    }

    /**
     * Nullify families property
     * @return $this
     */
    public function clearFamilies()
    {
        $this->families = new ArrayCollection;

        return $this;
    }

    /**
     * Setter for slug property 
     *
     * @param string|null 
     * @return $this
     */
    public function setSlug($slug = null)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Getter for slug property 
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Setter for unicode property 
     *
     * @param string 
     * @return $this
     */
    public function setUnicode($unicode = null)
    {
        $this->unicode = $unicode;

        return $this;
    }

    /**
     * Getter for unicode property 
     *
     * @return string 
     */
    public function getUnicode()
    {
        return $this->unicode;
    }

    /**
     * Setter for aliases property 
     *
     * @param array 
     * @return $this
     */
    public function setAliases($aliases = null)
    {
        $this->aliases = $aliases;

        return $this;
    }

    /**
     * Getter for aliases property 
     *
     * @return array 
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Checker for aliases property 
     *
     * @return bool
     */
    public function hasAliases()
    {
        return (bool) ($this->getAliases() !== null);
    }

    /**
     * Nullify aliases property 
     *
     * @return $this
     */
    public function clearAliases()
    {
        $this->aliases = null;

        return $this;
    }

    /**
     * Setter for categories property 
     *
     * @param array 
     * @return $this
     */
    public function setCategories($categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Getter for categories property 
     *
     * @return array 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Checker for categories property 
     *
     * @return bool
     */
    public function hasCategories()
    {
        return (bool) ($this->getCategories() !== null);
    }

    /**
     * Nullify categories property 
     *
     * @return $this
     */
    public function clearCategories()
    {
        $this->setCategories(null);

        return $this;
    }
}
