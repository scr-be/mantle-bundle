<?php

namespace Scribe\MantleBundle\Loader\Routing;

use Scribe\Teavee\ObjectCacheBundle\DependencyInjection\Aware\CacheManagerAwareTrait;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Scribe\Wonka\Exception\RuntimeException;
use Scribe\Wonka\Utility\Filter\StringFilter;
use Scribe\MantleBundle\Doctrine\Entity\Route\RouteRedirect;
use Scribe\MantleBundle\Doctrine\Repository\Route\RouteRedirectRepository;

/**
 * Class RouteRedirectLoader.
 */
class RouteRedirectLoader extends Loader
{
    use CacheManagerAwareTrait;

    /**
     * @var string
     */
    const SUPPORTED_TYPE = 's.mantle.redirects';

    /**
     * @var string[]
     */
    const DEFAULTS = [
        '_controller' => 's.mantle.route_redirect.controller:handleAction',
    ];

    /**
     * @var RouteRedirectRepository
     */
    protected $redirectRepo;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var string|null
     */
    protected $loaderContext;

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @param RouteRedirectRepository $redirectRepo
     */
    public function __construct(RouteRedirectRepository $redirectRepo)
    {
        $this->redirectRepo = $redirectRepo;
    }

    /**
     * @param string $resource
     * @param string $type
     *
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        $this->loaderContext = (string) ($resource === '.' ? null : $resource);

        return (bool) ($type === self::SUPPORTED_TYPE);
    }



    /**
     * @param mixed $resource
     * @param null  $type
     *
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        if ($this->loaded) {
            throw RuntimeException::create('Cannot add redirect loader "%s" more than once.', get_class($this));
        }

        foreach ($this->lookupRoutesEntities() as $entry) {
            $this->addRoute($this->createRoute($entry));
        }

        $this->loaded = true;

        return $this->routeCollection;
    }

    /**
     * @return bool
     */
    protected function hasRoute(Route $route)
    {
        return (bool) (in_array($route, $this->routeCollection->all(), true) ?: false);
    }

    /**
     * @param Route $route
     *
     * @return $this
     */
    protected function addRoute(Route $route)
    {
        if (true !== $this->hasRoute($route)) {
            $this->routeCollection->add($this->createRouteIndex(), $route);
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function createRouteIndex()
    {
        return (string) sprintf('_s_mantle_redirect_%\'.04d', (int) $this->routeCollection->count());
    }

    /**
     * @return array[]
     */
    protected function lookupRoutesEntities()
    {
        try {
            return (array) $this
                ->redirectRepo
                ->fineByContext($this->loaderContext);
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param RouteRedirect $route
     *
     * @return array
     */
    protected function getDynamicRouteDefaults(RouteRedirect $route)
    {
        if (true === $route->hasRouteDefaults()) {
            $defaults = array_merge(self::DEFAULTS, $route->getRouteDefaults());
        }

        $defaults['path'] = $route->getSearchPath();

        return $defaults;
    }

    /**
     * @param array $entry
     *
     * @return Route
     */
    protected function createRoute($entry)
    {
        $route = new Route();

        $searchPath = getArrayElement('searchPath', $entry);

        if (getArrayElement('regex', $entry)) {
            $route->setPattern($searchPath);
        } else {
            $route->setPath($searchPath);
        }


        $route = new Route(
            $routeEntity->getRedirectPath(),
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
}

/* EOF */
