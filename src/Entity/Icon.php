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
use Scribe\EntityTrait\HasName;
use Scribe\EntityTrait\HasSlug;
use Scribe\EntityTrait\HasAliases;
use Scribe\EntityTrait\HasCategories;
use Scribe\EntityTrait\HasAttributes;
use Scribe\EntityTrait\HasDescription;
use Scribe\Entity\AbstractEntity;

/**
 * Class Icon
 * @package Scribe\MantleBundle\Entity
 */
class Icon extends AbstractEntity
{
    /**
     * import name and description entity property traits
     */
    use HasName,
        HasSlug,
        HasAliases,
        HasCategories,
        HasAttributes,
        HasDescription;

    /**
     * @type ArrayCollection|IconFamily[]
     */
    private $families;

    /**
     * @var string 
     */
    private $unicode;

    /**
     * perform any entity setup
     */
    public function __construct()
    {
        $this->initAliases();
        $this->initAttributes();
        $this->initCategories();

        $this->families = new ArrayCollection;
    }

    /**
     * Support for casting from object type to string type
     * @return string
     */
    public function __toString()
    {
        if (false === $this->hasFamilies()) {
            return $this->getSlug();
        }

        $string = '';
        foreach ($this->getFamilies() as $f) {
            $string .= $f->getSlug().'-'.$this->getSlug().';';
        }

        return $string;
    }

    /**
     * Setter for families property
     * @param  ArrayCollection|IconFamily[] $families
     * @return $this
     */
    public function setFamilies(ArrayCollection $families = null)
    {
        $this->families = $families;

        return $this;
    }

    /**
     * Getter for families property
     * @return ArrayCollection|IconFamily[]
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
        return (bool) ($this->families !== null && $this->families->count() > 0);
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
}

/* EOF */
