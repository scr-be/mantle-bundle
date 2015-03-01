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

/**
 * Entity NavMenuItem
 */
class NavMenuItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $context;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $routeName;

    /**
     * @var array
     */
    private $routeParameters;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var array
     */
    private $roleRestrictions;

    /**
     * @var array
     */
    private $reverseRoleRestrictions;

    /**
     * @var integer
     */
    private $weight;

    /**
     * @var array
     */
    private $attr;

    /**
     * @var NavMenuSubItem
     */
    private $subItems;

    public function __construct()
    {
        $this->subItems = new ArrayCollection;
        $this->attr     = [];
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set context
     *
     * @param string $context
     * @return NavMenuItem
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return NavMenuItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set routeName
     *
     * @param string $routeName
     * @return NavMenuItem
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Set routeParameters
     *
     * @param array $routeParameters
     * @return NavMenuItem
     */
    public function setRouteParameters(array $routeParameters = array())
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }

    /**
     * Get routeParameters
     *
     * @return array
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return NavMenuItem
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return boolean
     */
    public function hasIcon()
    {
        return $this->icon ?
            true : false
        ;
    }

    /**
     * Set roleRestrictions
     *
     * @param array $roleRestrictions
     * @return NavMenuItem
     */
    public function setRoleRestrictions(array $roleRestrictions = array())
    {
        $this->roleRestrictions = $roleRestrictions;

        return $this;
    }

    /**
     * Get roleRestrictions
     *
     * @return array
     */
    public function getRoleRestrictions()
    {
        return $this->roleRestrictions;
    }

    /**
     * Set reverseRoleRestrictions
     *
     * @param string $reverseRoleRestrictions
     * @return NavMenuItem
     */
    public function setReverseRoleRestrictions(array $reverseRoleRestrictions = array())
    {
        $this->reverseRoleRestrictions = $reverseRoleRestrictions;

        return $this;
    }

    /**
     * Get reverseRoleRestrictions
     *
     * @return string
     */
    public function getReverseRoleRestrictions()
    {
        return $this->reverseRoleRestrictions;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return NavMenuItem
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param  ArrayCollection $subItems
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
     * @param  NavMenuSubItem $subItem
     * @return NavMenuItem
     */
    public function addSubItem(NavMenuSubItem $subItem)
    {
        $this->subItems->add($subItem);

        return $this;
    }

    /**
     * @param  NavMenuSubItem $subItem
     * @return NavMenuItem
     */
    public function removeSubItem(NavMenuSubItem $subItem)
    {
        $this->subItems->removeElement($subItem);

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHeader()
    {
        return false;
    }

    public function setAttrValue($index, $value)
    {
        $this->attr[(string)$index] = $value;
    }

    /**
     * @param string $index
     */
    public function getAttrValue($index)
    {
        if ($this->attr === null || !array_key_exists($index, $this->attr)) {
            return null;
        }

        return $this->attr[$index];
    }
}
