<?php

namespace Scribe\MantleBundle\Doctrine\Entity\Route;

use Scribe\Doctrine\ORM\Mapping\SlugEntity;

/**
 * RouteRedirect.
 */
class RouteRedirect extends SlugEntity
{
    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var string
     */
    protected $redirectPath;

    /**
     * @var string
     */
    protected $searchPath;

    /**
     * @var bool
     */
    protected $regex;

    /**
     * @var string|null
     */
    protected $context;

    /**
     * @var array|null
     */
    protected $routeDefaults;

    /**
     * @var array|null
     */
    protected $routeMethods;

    /**
     * @var array|null
     */
    protected $routeSchemes;

    /**
     * @var array|null
     */
    protected $routeRequirements;

    /**
     * @var string|null
     */
    protected $routeHost;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->redirectPath.' -> '.$this->searchPath;
    }

    /**
     * @param string $redirectPath
     *
     * @return $this
     */
    public function setRedirectPath($redirectPath)
    {
        $this->redirectPath = $redirectPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectPath()
    {
        return $this->redirectPath;
    }

    /**
     * @param string $searchPath
     *
     * @return $this
     */
    public function setSearchPath($searchPath)
    {
        $this->searchPath = $searchPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getSearchPath()
    {
        return $this->searchPath;
    }

    /**
     * @param bool $regex
     *
     * @return $this
     */
    public function setRegex($regex)
    {
        $this->regex = (bool) $regex;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @param string $context
     *
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return array|null
     */
    public function getRouteDefaults()
    {
        return $this->routeDefaults;
    }

    /**
     * @param array|null $routeDefaults
     */
    public function setRouteDefaults($routeDefaults)
    {
        $this->routeDefaults = $routeDefaults;
    }

    /**
     * @return bool
     */
    public function hasRouteDefaults()
    {
        return (bool) ($this->routeDefaults !== null ?: false);
    }

    /**
     * @return array|null
     */
    public function getRouteMethods()
    {
        return $this->routeMethods;
    }

    /**
     * @param array|null $routeMethods
     */
    public function setRouteMethods($routeMethods)
    {
        $this->routeMethods = $routeMethods;
    }

    /**
     * @return bool
     */
    public function hasRouteMethods()
    {
        return (bool) ($this->routeMethods !== null ?: false);
    }

    /**
     * @return array|null
     */
    public function getRouteSchemes()
    {
        return $this->routeSchemes;
    }

    /**
     * @param array|null $routeSchemes
     */
    public function setRouteSchemes($routeSchemes)
    {
        $this->routeSchemes = $routeSchemes;
    }

    /**
     * @return bool
     */
    public function hasRouteSchemes()
    {
        return (bool) ($this->routeSchemes !== null ?: false);
    }

    /**
     * @return array|null
     */
    public function getRouteRequirements()
    {
        return $this->routeRequirements;
    }

    /**
     * @param array|null $routeRequirements
     */
    public function setRouteRequirements($routeRequirements)
    {
        $this->routeRequirements = $routeRequirements;
    }

    /**
     * @return bool
     */
    public function hasRouteRequirements()
    {
        return (bool) ($this->routeRequirements !== null ?: false);
    }

    /**
     * @return null|string
     */
    public function getRouteHost()
    {
        return $this->routeHost;
    }

    /**
     * @param null|string $routeHost
     */
    public function setRouteHost($routeHost)
    {
        $this->routeHost = $routeHost;
    }

    /**
     * @return bool
     */
    public function hasRouteHost()
    {
        return (bool) ($this->routeHost !== null ?: false);
    }
}

/* EOF */
