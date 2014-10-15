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

use Scribe\SharedBundle\Entity\NavMenuItem;

/**
 * Entity NavMenuSubItem
 */
class NavMenuSubItem
{
    /**
     * @var integer
     */
    private $id;

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
     * @var string
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
     * @var boolean
     */
    private $header;

    /**
     * @var NavMenuItem
     */
    private $parent;

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
     * Set title
     *
     * @param string $title
     * @return NavMenuSubItem
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
     * @return NavMenuSubItem
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
     * @return NavMenuSubItem
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
     * @return NavMenuSubItem
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
     * @param string $roleRestrictions
     * @return NavMenuSubItem
     */
    public function setRoleRestrictions(array $roleRestrictions = array())
    {
        $this->roleRestrictions = $roleRestrictions;

        return $this;
    }

    /**
     * Get roleRestrictions
     *
     * @return string
     */
    public function getRoleRestrictions()
    {
        return $this->roleRestrictions;
    }

    /**
     * Set reverseRoleRestrictions
     *
     * @param string $reverseRoleRestrictions
     * @return NavMenuSubItem
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
     * @return NavMenuSubItem
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
     * @param  boolean $header
     * @return NavMenuSubItem
     */
    public function setHeader($header = null)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return boolean
     */
    public function isHeader()
    {
        return $this->header ?
            true : false
        ;
    }

    /**
     * @return boolean
     */
    public function hasSubItems()
    {
        return false;
    }

    /**
     * @param  NavMenuItem $parent
     * @return $this
     */
    public function setParent(NavMenuItem $parent)
    {
        $this->parent = $parent;

        return $this;
    }
}
