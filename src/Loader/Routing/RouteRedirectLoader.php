<?php

namespace Scribe\MantleBundle\Loader\Routing;

use Scribe\Teavee\ObjectCacheBundle\DependencyInjection\Aware\CacheManagerAwareTrait;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Scribe\Wonka\Exception\RuntimeException;
use Scribe\Wonka\Utility\Filter\StringFilter;
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
        $this->routeCollection = new RouteCollection();
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

        foreach ($this->lookupRouteEntities() as $entry) {
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
     * @return mixed[]
     */
    protected function lookupRouteEntities()
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
     * @param mixed $entry
     *
     * @return array
     */
    protected function getDynamicRouteDefaults(array $entry)
    {
        $defaults = array_merge(self::DEFAULTS, ['path' => $entry['redirectPath']]);

        if (array_key_exists('routeDefaults', $entry)) {
            $defaults = array_merge($defaults, $entry['routeDefaults']);
        }

        return $defaults;
    }

    /**
     * @param mixed[] $entry
     *
     * @return Route
     */
    protected function createRoute($entry)
    {
        $route = new Route(getArrayElement('searchPath', $entry));
        $route->setDefaults($this->getDynamicRouteDefaults($entry));

        $this->assignRouteValue('host', $entry, $route);
        $this->assignRouteValue('methods', $entry, $route);
        $this->assignRouteValue('requirements', $entry, $route);
        $this->assignRouteValue('schemas', $entry, $route);

        return $route;
    }

    /**
     * @param string  $what
     * @param mixed[] $entry
     * @param Route   $route
     */
    protected function assignRouteValue($what, array $entry, Route $route)
    {
        if ($value = getArrayElement('route' . ucfirst($what), $entry)) {
            $method = 'set' . ucfirst($what);
            $route->{$method}($value);
        }
    }
}

/* EOF */
