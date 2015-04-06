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
use Scribe\Doctrine\Base\Model\HasName;
use Scribe\Doctrine\Base\Model\HasAliases;
use Scribe\Doctrine\Base\Model\HasCategories;
use Scribe\Doctrine\Base\Model\HasAttributes;
use Scribe\Doctrine\Base\Model\HasDescription;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Behavior\Model\Sluggable\SluggableBehaviorTrait;
use Scribe\Doctrine\Exception\ORMExceptionInterface;
use Scribe\Doctrine\Exception\SubscriberEventORMException;

/**
 * Class Icon.
 */
class Icon extends AbstractEntity
{
    /*
     * import name and description entity property traits
     */
    use HasName,
        HasAliases,
        HasCategories,
        HasAttributes,
        HasDescription,
        SluggableBehaviorTrait;

    /**
     * @var ArrayCollection|IconFamily[]
     */
    private $families;

    /**
     * @var string
     */
    private $unicode;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        parent::__construct();

        $this->families = new ArrayCollection();
    }

    /**
     * Support for casting from object type to string type.
     *
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
     * This entity must not have auto-generated slugs.
     *
     * @throws SubscriberEventORMException
     */
    public function getAutoSlugFields()
    {
        throw new SubscriberEventORMException(
            'This entity does not support automatically generating slugs!',
            ORMExceptionInterface::CODE_GENERIC_FROM_MANTLE_BDL
        );
    }

    /**
     * Disable auto-generated slugs.
     *
     * @return bool
     */
    public function isSlugAutoGenerated()
    {
        return false;
    }

    /**
     * Setter for families property.
     *
     * @param ArrayCollection|IconFamily[] $families
     *
     * @return $this
     */
    public function setFamilies(ArrayCollection $families = null)
    {
        $this->families = $families;

        return $this;
    }

    /**
     * Getter for families property.
     *
     * @return ArrayCollection|IconFamily[]
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * Checker for families property.
     *
     * @return bool
     */
    public function hasFamilies()
    {
        return (bool) ($this->families !== null && $this->families->count() > 0);
    }

    /**
     * Nullify families property.
     *
     * @return $this
     */
    public function clearFamilies()
    {
        $this->families = new ArrayCollection();

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
}

/* EOF */