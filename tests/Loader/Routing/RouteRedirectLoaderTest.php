<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Component\Controller\Behaviors;

use Scribe\MantleBundle\Doctrine\Repository\Route\RouteRedirectRepository;
use Scribe\MantleBundle\Loader\Routing\RouteRedirectLoader;
use Scribe\WonkaBundle\Utility\TestCase\KernelTestCase;

/**
 * RouteRedirectLoaderTest.
 */
class RouteRedirectLoaderTest extends KernelTestCase
{
    /**
     * @var RouteRedirectRepository
     */
    public static $routeRedirectRepo;

    /**
     * @var RouteRedirectLoader
     */
    public static $loader;

    public function setUp()
    {
        parent::setUp();

        static::$routeRedirectRepo = self::$staticContainer->get('s.mantle.route_redirect.repo');
        static::$loader = new RouteRedirectLoader(static::$routeRedirectRepo);
    }

    public function testSupports()
    {
        static::assertFalse(static::$loader->supports('.', 'invalid-type'));
        static::assertTrue(static::$loader->supports('.', 's.mantle.redirects'));
    }

    public function testLoad()
    {
        $routeCollection = static::$loader->load('.', 's.mantle.redirects');

        static::assertInstanceOf('Symfony\Component\Routing\RouteCollection', $routeCollection);
        static::assertNotEquals(0, $routeCollection->count());

        foreach ($routeCollection as $route) {
            static::assertInstanceOf('Symfony\Component\Routing\Route', $route);
        }
    }

    public function testLoadTwiceException()
    {
        $this->setExpectedException(
            'Scribe\Wonka\Exception\RuntimeException',
            'Cannot add redirect loader "Scribe\MantleBundle\Loader\Routing\RouteRedirectLoader" more than once.'
        );

        static::$loader->load('.', 's.mantle.redirects');
        static::$loader->load('.', 's.mantle.redirects');
    }
}

/* EOF */
