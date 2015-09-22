<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Icon;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;
use Scribe\MantleBundle\Doctrine\Base\Model\HasAliases;
use Scribe\MantleBundle\Doctrine\Base\Model\HasCategories;
use Scribe\MantleBundle\Doctrine\Base\Model\HasAttributes;
use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\HasSlug;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;
use Scribe\MantleBundle\Doctrine\Behavior\Model\Sluggable\SluggableBehaviorStaticTrait;

/**
 * Class Icon.
 */
class Icon extends AbstractEntity
{
    /*
     * import name and description entity property traits
     */
    use HasName;
    use HasAliases;
    use HasCategories;
    use HasAttributes;
    use HasDescription;
    use HasSlug;

    /**
     * @var string
     */
    protected $unicode;

    /**
     * @var ArrayCollection|IconFamily[]
     */
    protected $familyCollection;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        if (false === $this->hasFamilyCollection() && false === empty($this->getSlug())) {
            return $this->getSlug();
        }

        $slug = $this->getSlug();
        foreach ($this->getFamilyCollection() as $f) {
            $slug .= '+'.$f->getSlug();
        }

        return (string) $slug;
    }

    /**
     * @return $this
     */
    public function initializeFamilyCollection()
    {
        $this->familyCollection = new ArrayCollection;

        return $this;
    }

    /**
     * Setter for unicode property.
     *
     * @param string
     *
     * @return $this
     */
    public function setUnicode($unicode = null)
    {
        $this->unicode = $unicode;

        return $this;
    }

    /**
     * Getter for unicode property.
     *
     * @return string
     */
    public function getUnicode()
    {
        return $this->unicode;
    }

    /**
     * Setter for familyCollection property.
     *
     * @param ArrayCollection|IconFamily[] $families
     *
     * @return $this
     */
    public function setFamilyCollection(ArrayCollection $families = null)
    {
        $this->familyCollection = $families;

        return $this;
    }

    /**
     * Getter for familyCollection property.
     *
     * @return ArrayCollection|IconFamily[]
     */
    public function getFamilyCollection()
    {
        return $this->familyCollection;
    }

    /**
     * Checker for familyCollection property.
     *
     * @return bool
     */
    public function hasFamilyCollection()
    {
        return (bool) ($this->familyCollection !== null && $this->familyCollection->count() > 0);
    }

    /**
     * Nullify familyCollection property.
     *
     * @return $this
     */
    public function clearFamilyCollection()
    {
        $this->familyCollection = new ArrayCollection();

        return $this;
    }

    /**
     * Setter for familyCollection property.
     *
     * @param ArrayCollection|IconFamily[] $families
     *
     * @return $this
     *
     * @deprecated
     */
    public function setFamilies(ArrayCollection $families = null)
    {
        return $this->setFamilyCollection($families);
    }

    /**
     * Getter for familyCollection property.
     *
     * @return ArrayCollection|IconFamily[]
     *
     * @deprecated
     */
    public function getFamilies()
    {
        return $this->getFamilyCollection();
    }

    /**
     * Checker for familyCollection property.
     *
     * @return bool
     *
     * @deprecated
     */
    public function hasFamilies()
    {
        return $this->hasFamilyCollection();
    }

    /**
     * Nullify familyCollection property.
     *
     * @return $this
     *
     * @deprecated
     */
    public function clearFamilies()
    {
        return $this->clearFamilyCollection();
    }
}

/* EOF */
