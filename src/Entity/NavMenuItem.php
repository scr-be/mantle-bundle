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
use Scribe\Entity\AbstractEntity;
use Scribe\EntityTrait\HasSlug;
use Scribe\EntityTrait\HasTitle;
use Scribe\EntityTrait\HasWeight;
use Scribe\EntityTrait\HasContext;
use Scribe\EntityTrait\HasIconAsString;
use Scribe\EntityTrait\HasAttrs;
use Scribe\EntityTrait\HasRouteName;
use Scribe\EntityTrait\HasRouteParameters;
use Scribe\EntityTrait\HasRoleRestrictionsAsArrayOwningSide;
use Scribe\EntityTrait\HasReverseRoleRestrictionsAsArrayOwningSide;

/**
 * Entity NavMenuItem.
 */
class NavMenuItem extends AbstractEntity
{
    use HasSlug,
        HasTitle,
        HasWeight,
        HasContext,
        HasIconAsString,
        HasAttrs,
        HasRouteName,
        HasRouteParameters,
        HasRoleRestrictionsAsArrayOwningSide,
        HasReverseRoleRestrictionsAsArrayOwningSide;

    /**
     * @var NavMenuSubItem
     */
    private $subItems;

    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__.':'.$this->routeName;
    }

    /**
     * Setup entity.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initSlug();
        $this->initIcon();
        $this->initAttrs();
        $this->initRouteName();
        $this->initRouteParameters();
        $this->initRoleRestrictionsAsArray();
        $this->initReverseRoleRestrictionsAsArray();

        $this->subItems = new ArrayCollection();
    }

    /**
     * @param ArrayCollection $subItems
     *
     * @return NavMenuItem
     */
    public function setSubItems(ArrayCollection $subItems)
    {
        $this->subItems = $subItems;

        return $this;
    }

    /**
     * @return NavMenuSubItem
     */
    public function getSubItems()
    {
        return $this->subItems;
    }

    /**
     * @return boolean
     */
    public function hasSubItems()
    {
        return count($this->subItems) > 0 ?
            true : false
        ;
    }

    /**
     * @param NavMenuSubItem $subItem
     *
     * @return NavMenuItem
     */
    public function addSubItem(NavMenuSubItem $subItem)
    {
        $this->subItems->add($subItem);

        return $this;
    }

    /**
     * @param NavMenuSubItem $subItem
     *
     * @return NavMenuItem
     */
    public function removeSubItem(NavMenuSubItem $subItem)
    {
        $this->subItems->removeElement($subItem);

        return $this;
    }

    /**
     * @return bool
     */
    public function isHeader()
    {
        return false;
    }
}

/* EOF */
