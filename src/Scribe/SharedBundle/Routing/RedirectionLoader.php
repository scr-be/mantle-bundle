<?php

namespace Scribe\SharedBundle\Routing;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Scribe\Component\DependencyInjection\ContainerAwareTrait;
use Scribe\Filter\String;

/**
 * loader service to handle redirection urls
 */
class RedirectionLoader extends Loader implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var boolean
     */
    private $loaded = false;

    /**
     * @param $container ContainerInterface
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * @inherit
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Cannot add '.__CLASS__.' to the resolver twice.');
        }

        $em = $this
            ->getContainer()
            ->get('doctrine.orm.default_entity_manager')
        ;

        $repo = $em
            ->getRepository('ScribeSharedBundle:Redirects')
        ;

        $redirects = $repo->findAll();

        $routes = new RouteCollection();

        foreach ($redirects as $i => $r) {

            $routeName = '__redirection_'.$i.'_'.String::alphanumericOnly($r->getPattern());

            $pattern = $r->getPattern();
            $defaults = [
                '_controller' => 'ScribeSharedBundle:Redirect:Handle',
                'destination' => $r->getDestination()
            ];

            $route = new Route($pattern, $defaults);
            $routes->add($routeName, $route);
        }

        $this->loaded = true;

        return $routes;
    }

    /**
     * @inherit
     */
    public function supports($resource, $type = null)
    {
        return $type === 'redirection';
    }
}
