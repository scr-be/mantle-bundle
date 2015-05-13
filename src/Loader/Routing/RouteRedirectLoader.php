<?php

namespace Scribe\MantleBundle\Loader\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Scribe\Exception\RuntimeException;
use Scribe\Utility\Filter\StringFilter;
use Scribe\MantleBundle\Doctrine\Entity\Route\RouteRedirect;
use Scribe\MantleBundle\Doctrine\Repository\Route\RouteRedirectRepository;

/**
 * Class RouteRedirectLoader.
 *
 * Loader service to handle redirection urls.
 */
class RouteRedirectLoader extends Loader
{
    /**
     * @var string
     */
    const SUPPORTED_TYPE = 'MantleBundle_RouteRedirectLoader';

    /**
     * @var array
     */
    private static $routeDefaultDefaults = [
        '_controller' => 's.mantle.route_redirect.controller:handleAction'
    ];

    /**
     * @var RouteRedirectRepository
     */
    private $routeRedirectRepo;

    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var bool
     */
    private $loaded = false;

    /**
     * @param $routeRedirectRepo RouteRedirectRepository
     */
    public function __construct(RouteRedirectRepository $routeRedirectRepo)
    {
        $this->routeRedirectRepo = $routeRedirectRepo;
    }

    /**
     * @param string $resource
     * @param string $type
     *
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return (bool) ($type === self::SUPPORTED_TYPE ?: false);
    }

    /**
     * @return array
     */
    private static function getRouteDefaultDefaults()
    {
        return self::$routeDefaultDefaults;
    }

    /**
     * @return RouteCollection
     */
    private function getRouteCollection()
    {
        return $this->routeCollection;
    }

    /**
     * @param RouteCollection $routeCollection
     */
    private function setRouteCollection($routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    /**
     * @return bool
     */
    private function hasRoute(Route $route)
    {
        return (bool) (in_array($route, $this->getRouteCollection()->all(), true) ?: false);
    }

    /**
     * @param Route $route
     *
     * @return $this
     */
    private function addRoute(Route $route)
    {
        if (true !== $this->hasRoute($route)) {
            $this->getRouteCollection()->add(
                $this->getDynamicRouteName($route->getPath()),
                $route
            );
        }

        return $this;
    }

    /**
     * @return boolean
     */
    private function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * @param boolean $loaded
     */
    private function setLoaded($loaded)
    {
        $this->loaded = $loaded;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function getDynamicRouteName($name)
    {
        return (string) sprintf(
            '__ScribeMantleBundle_RouteRedirectLoader_%\'.04d_%s',
            (int)    $this->getRouteCollection()->count(),
            (string) StringFilter::alphanumericOnly($name)
        );
    }

    /**
     * @return RouteRedirect[]
     */
    private function initializeRouteRedirectCollection()
    {
        $this->setRouteCollection(new RouteCollection());

        $customRoutes = $this
            ->routeRedirectRepo
            ->findAll()
        ;

        if (false === is_array($customRoutes) ||0 === count($customRoutes)) {
            return [];
        }

        return $customRoutes;
    }

    /**
     * @param RouteRedirect $route
     *
     * @return array
     */
    private function getDynamicRouteDefaults(RouteRedirect $route)
    {
        $defaults = self::getRouteDefaultDefaults();

        if (true === $route->hasRouteDefaults()) {
            $defaults = array_merge(
                $defaults,
                $route->getRouteDefaults()
            );
        }

        $defaults['path'] = $route->getPathRedirect();

        return $defaults;
    }

    /**
     * @param RouteRedirect $routeEntity
     *
     * @return Route
     */
    private function createRoute(RouteRedirect $routeEntity)
    {
        $route = new Route(
            $routeEntity->getPath(),
            $this->getDynamicRouteDefaults($routeEntity)
        );

        if ($routeEntity->hasRouteHost()) {
            $route->setHost($routeEntity->getRouteHost());
        }

        if ($routeEntity->hasRouteMethods()) {
            $route->setMethods($routeEntity->getRouteMethods());
        }

        if ($routeEntity->hasRouteRequirements()) {
            $route->setRequirements($routeEntity->getRouteRequirements());
        }

        if ($routeEntity->hasRouteSchemas()) {
            $route->setSchemes($routeEntity->getRouteSchemas());
        }

        return $route;
    }

    /**
     * @param mixed $resource
     * @param null  $type
     *
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        if (true === $this->isLoaded()) {
            throw new RuntimeException(
                'Cannot add the redirection route loader "%s" to the route resolver more than once.',
                null, null, null,
                __CLASS__
            );
        }

        $customRouteCollection = $this->initializeRouteRedirectCollection();

        foreach ($customRouteCollection as $routeKey => $routeEntity) {
            $this->addRoute($this->createRoute($routeEntity));
        }

        $this->setLoaded(true);

        return $this->getRouteCollection();
    }
}

/* EOF */
