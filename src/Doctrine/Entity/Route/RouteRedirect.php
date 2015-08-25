<?php

namespace Scribe\MantleBundle\Doctrine\Entity\Route;

use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * RouteRedirect.
 */
class RouteRedirect extends AbstractEntity
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $pathRedirect;

    /**
     * @var bool
     */
    protected $pathMatchRegex;

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
    protected $routeSchemas;

    /**
     * @var array|null
     */
    protected $routeRequirements;

    /**
     * @var string|null
     */
    protected $routeHost;

    /**
     * @return $this
     */
    public function initializePathMatchRegex()
    {
        $this->pathMatchRegex = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeRouteDefaults()
    {
        $this->routeDefaults = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeRouteMethods()
    {
        $this->routeMethods = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeRouteSchemas()
    {
        $this->routeSchemas = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeRouteRequirements()
    {
        $this->routeRequirements = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeRouteHost()
    {
        $this->routeHost = null;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->path.' -> '.$this->pathRedirect;
    }

    /**
     * Set pathFrom.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get pathFrom.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set pathTo.
     *
     * @param string $pathRedirect
     *
     * @return $this
     */
    public function setPathRedirect($pathRedirect)
    {
        $this->pathRedirect = $pathRedirect;

        return $this;
    }

    /**
     * Get pathTo.
     *
     * @return string
     */
    public function getPathRedirect()
    {
        return $this->pathRedirect;
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
    public function getRouteSchemas()
    {
        return $this->routeSchemas;
    }

    /**
     * @param array|null $routeSchemas
     */
    public function setRouteSchemas($routeSchemas)
    {
        $this->routeSchemas = $routeSchemas;
    }

    /**
     * @return bool
     */
    public function hasRouteSchemas()
    {
        return (bool) ($this->routeSchemas !== null ?: false);
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
