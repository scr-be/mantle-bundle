<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Navigation;

use Scribe\Doctrine\ORM\Mapping\IdEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;
use Scribe\MantleBundle\Doctrine\Base\Model\HasAttributes;
use Scribe\MantleBundle\Doctrine\Base\Model\HasChildrenInverseSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasParentOwningSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasWeight;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;
use Scribe\MantleBundle\Doctrine\Base\Model\HasRoleReverseRestrictionsOwningSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasRoute;
use Scribe\MantleBundle\Doctrine\Behavior\Model\Sluggable\SluggableBehaviorTrait;

/**
 * Class NavigationItem.
 */
class NavigationItem extends IdEntity
{
    use HasName;
    use HasDescription;
    use HasWeight;
    use HasAttributes;
    use HasRoute;
    use HasChildrenInverseSide;
    use HasParentOwningSide;
    use HasRoleReverseRestrictionsOwningSide;
    use SluggableBehaviorTrait;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var NavigationSet|null
     */
    protected $root;

    /**
     * @var array
     */
    protected $restrictions;

    /**
     * @var array
     */
    protected $restrictionsInverse;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Fallback for auto slug creation if one is not explicitly set.
     *
     * @return array
     */
    public function getAutoSlugFields()
    {
        return [
            'name',
        ];
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
     * Initialize null root by default.
     */
    public function initializeRoot()
    {
        $this->root = null;
    }

    /**
     * Initialize empty array for restrictions.
     */
    public function initializeRestrictions()
    {
        $this->restrictions = [];
    }

    /**
     * Initialize empty array for reverse restrictions.
     */
    public function initializeRestrictionsInverse()
    {
        $this->restrictionsInverse = [];
    }

    /**
     * @param NavigationSet $root
     *
     * @return $this
     */
    public function setRoot(NavigationSet $root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @return null|NavigationSet
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @return bool
     */
    public function hasRoot()
    {
        return (bool) ($this->root instanceof NavigationSet ?: false);
    }

    /**
     * @return $this
     */
    public function clearRoot()
    {
        $this->initializeRoot();

        return $this;
    }

    /**
     * @param string[] $restrictions
     *
     * @return $this
     */
    public function setRestrictions(array $restrictions = [])
    {
        $this->restrictions = $restrictions;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getRestrictions()
    {
        return $this->restrictions;
    }

    /**
     * @param string $restriction
     *
     * @return bool
     */
    public function hasRestriction($restriction)
    {
        return (bool) (in_array((string) $restriction, $this->restrictions, true) ?: false);
    }

    /**
     * @param string $restriction
     *
     * @return $this
     */
    public function addRestriction($restriction)
    {
        if (false === $this->hasRestriction($restriction)) {
            $this->restrictions[] = $restriction;
        }

        return $this;
    }

    /**
     * @param string $restriction
     *
     * @return $this
     */
    public function removeRestriction($restriction)
    {
        array_filter($this->restrictions, function ($r) use ($restriction) {
            return (bool) ($r === $restriction ? false : true);
        });

        return $this;
    }

    /**
     * @return $this
     */
    public function clearRestrictions()
    {
        $this->initializeRestrictions();

        return $this;
    }

    /**
     * @param string[] $restrictionsInverse
     *
     * @return $this
     */
    public function setRestrictionsInverse(array $restrictionsInverse = [])
    {
        $this->restrictionsInverse = $restrictionsInverse;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getRestrictionsInverse()
    {
        return $this->restrictionsInverse;
    }

    /**
     * @param string $restrictionInverse
     *
     * @return bool
     */
    public function hasRestrictionInverse($restrictionInverse)
    {
        return (bool) (in_array((string) $restrictionInverse, $this->restrictionsInverse, true) ?: false);
    }

    /**
     * @param string $restrictionInverse
     *
     * @return $this
     */
    public function addRestrictionInverse($restrictionInverse)
    {
        if (false === $this->hasRestrictionInverse($restrictionInverse)) {
            $this->restrictionsInverse[] = $restrictionInverse;
        }

        return $this;
    }

    /**
     * @param string $restrictionInverse
     *
     * @return $this
     */
    public function removeRestrictionInverse($restrictionInverse)
    {
        array_filter($this->restrictionsInverse, function ($r) use ($restrictionInverse) {
            return (bool) ($r === $restrictionInverse ? false : true);
        });

        return $this;
    }

    /**
     * @return $this
     */
    public function clearRestrictionsInverse()
    {
        $this->initializeRestrictionsInverse();

        return $this;
    }
}

/* EOF */
