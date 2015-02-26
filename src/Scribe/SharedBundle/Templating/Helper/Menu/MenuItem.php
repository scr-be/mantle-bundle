<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Helper\Menu;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MenuItem
 */
class MenuItem implements MenuInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface|null
     */
    private $container = null;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $routeName = null;

    /**
     * @var array
     */
    private $routeParameters = [];

    /**
     * @var string
     */
    private $icon = null;

    /**
     * @var boolean
     */
    private $header = false;

    /**
     * @var array
     */
    private $subMenus = [];

    /**
     * @var boolean
     */
    private $forceActive = false;

    /**
     * @param ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param  string $title
     * @return MenuItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  string $forceActive
     * @return MenuItem
     */
    public function setForceActive($forceActive)
    {
        $this->forceActive = (boolean)$forceActive;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getForceActive()
    {
        return $this->forceActive;
    }

    /**
     * @param  string $icon
     * @return MenuItem
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
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
     * @param  string|null $routeName
     * @return MenuItem
     */
    public function setRouteName($routeName = null)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @param  array $routeParameters
     * @return MenuItem
     */
    public function setRouteParameters(array $routeParameters = array())
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }

    /**
     * @return array
     */
    public function getRouteParameters()
    {
        return (array)$this->routeParameters;
    }

    /**
     * @param  string|null $routeName
     * @param  array       $routeParameters
     * @return MenuItem
     */
    public function setRoute($routeName = null, array $routeParameters = array())
    {
        $this->setRouteName($routeName);
        $this->setRouteParameters($routeParameters);

        return $this;
    }

    /**
     * @param  array $subMenus
     * @return MenuItem
     */
    public function setSubMenus(array $subMenus = array())
    {
        $this->subMenus = $subMenus;

        return $this;
    }

    /**
     * @return array
     */
    public function getSubMenus()
    {
        return $this->subMenus;
    }

    /**
     * @return boolean
     */
    public function hasSubMenus()
    {
        return count($this->subMenus) > 0 ?
            true : false
        ;
    }

    /**
     * @param  boolean $header
     * @return MenuItem
     */
    public function setHeader($header = false)
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
    public function isActive()
    {
        if ($this->forceActive === true) {
            return true;
        }

        $route = $this
            ->container
            ->get('request')
            ->attributes
            ->get('_route')
        ;

        if ($this->getRouteName() == $route) {
            return true;
        }

        foreach ($this->getSubMenus() as $m) {
            if ($m->isActive() === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function generateUrl()
    {
        if ($this->routeName === null) {
            return '#';
        }

        return $this
            ->container
            ->get('router')
            ->generate(
                $this->routeName,
                $this->routeParameters
            )
        ;
    }

}
