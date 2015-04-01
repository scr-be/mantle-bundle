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
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasDescription;
use Scribe\Doctrine\Base\Model\HasSlug;
use Scribe\Doctrine\Base\Model\HasTitle;
use Scribe\Doctrine\Base\Model\HasWeight;
use Scribe\Doctrine\Base\Model\HasContext;
use Scribe\Doctrine\Base\Model\HasIconAsString;
use Scribe\Doctrine\Base\Model\HasAttrs;
use Scribe\Doctrine\Base\Model\HasRouteName;
use Scribe\Doctrine\Base\Model\HasRouteParameters;
use Scribe\Doctrine\Base\Model\HasRoleRestrictionsAsArrayOwningSide;
use Scribe\Doctrine\Base\Model\HasReverseRoleRestrictionsAsArrayOwningSide;

/**
 * Entity NavMenuItem.
 */
class NavMenuItem extends AbstractEntity
{
    use HasSlug,
        HasTitle,
        HasWeight,
        HasContext,
        HasDescription,
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
