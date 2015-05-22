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

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;
use Scribe\MantleBundle\Component\Controller\Behaviors\ControllerBehaviors;
use Scribe\MantleBundle\Component\Controller\Behaviors\ControllerBehaviorsInterface;
use Scribe\MantleBundle\Doctrine\Entity\Route\Route;

/**
 * Class ControllerBehaviorsTest.
 */
class ControllerBehaviorsTest extends AbstractMantleKernelTestCase
{
    /**
     * @var ControllerBehaviors
     */
    public $controllerBehaviors;

    public function setUp()
    {
        parent::setUp();

        $this->controllerBehaviors = new ControllerBehaviors();
        $this->controllerBehaviors->setServiceContainer($this->container);
    }

    public function testContainer()
    {
        static::assertEquals($this->container, $this->controllerBehaviors->container());
    }

    public function testGetServiceCollectionVariadic()
    {
        $expected = [
            'router' => $this->container->get('router'),
            'twig' => $this->container->get('twig'),
        ];

        $result = $this->controllerBehaviors->getServiceCollection('router', 'twig');

        static::assertEquals($expected, $result);
    }

    public function testGetServiceCollectionArray()
    {
        $expected = [
            'router' => $this->container->get('router'),
            'twig' => $this->container->get('twig'),
        ];

        $result = $this->controllerBehaviors->getServiceCollection(['router', 'twig']);

        static::assertEquals($expected, $result);
    }

    public function testGetServiceCollectionMixed()
    {
        $expected = [
            'router' => $this->container->get('router'),
            'twig' => $this->container->get('twig'),
            'translator' => $this->container->get('translator'),
            'session' => $this->container->get('session'),
        ];

        $result = $this->controllerBehaviors->getServiceCollection('router', 'twig', ['translator', 'session']);

        static::assertEquals($expected, $result);
    }

    public function testGetServiceCollectionException()
    {
        $this->setExpectedException(
            'Scribe\Component\DependencyInjection\Exception\InvalidContainerServiceException',
            'The requested container service "abcdef0123" could not be found.'
        );

        $this->controllerBehaviors->getServiceCollection('abcdef0123', '0123abcdef');
    }

    public function testGetService()
    {
        $expected = $this->container->get('router');
        $result = $this->controllerBehaviors->getService('router');

        static::assertEquals($expected, $result);
    }

    public function testGetServiceException()
    {
        $this->setExpectedException(
            'Scribe\Component\DependencyInjection\Exception\InvalidContainerServiceException',
            'The requested container service "abcdef0123" could not be found.'
        );

        $this->controllerBehaviors->getService('abcdef0123');
    }

    public function testHasService()
    {
        static::assertTrue($this->controllerBehaviors->hasService('router'));
        static::assertFalse($this->controllerBehaviors->hasService('abcdef0123'));
    }

    public function testGetParameterCollectionVariadic()
    {
        $expected = [
            'router.class' => $this->container->getParameter('router.class'),
            'twig.class' => $this->container->getParameter('twig.class'),
        ];

        $result = $this->controllerBehaviors->getParameterCollection('router.class', 'twig.class');

        static::assertEquals($expected, $result);
    }

    public function testGetServiceParameterArray()
    {
        $expected = [
            'router.class' => $this->container->getParameter('router.class'),
            'twig.class' => $this->container->getParameter('twig.class'),
        ];

        $result = $this->controllerBehaviors->getParameterCollection(['router.class', 'twig.class']);

        static::assertEquals($expected, $result);
    }

    public function testGetParameterCollectionMixed()
    {
        $expected = [
            'router.class' => $this->container->getParameter('router.class'),
            'twig.class' => $this->container->getParameter('twig.class'),
            'translator.class' => $this->container->getParameter('translator.class'),
            'session.class' => $this->container->getParameter('session.class'),
        ];

        $result = $this->controllerBehaviors->getParameterCollection('router.class', 'twig.class', ['translator.class', 'session.class']);

        static::assertEquals($expected, $result);
    }

    public function testGetServiceParameterException()
    {
        $this->setExpectedException(
            'Scribe\Component\DependencyInjection\Exception\InvalidContainerParameterException',
            'The requested container parameter "abcdef0123" could not be found.'
        );

        $this->controllerBehaviors->getParameterCollection('abcdef0123', '0123abcdef');
    }

    public function testGetParameter()
    {
        $expected = $this->container->getParameter('router.class');
        $result = $this->controllerBehaviors->getParameter('router.class');

        static::assertEquals($expected, $result);
    }

    public function testGetParameterException()
    {
        $this->setExpectedException(
            'Scribe\Component\DependencyInjection\Exception\InvalidContainerParameterException',
            'The requested container parameter "abcdef0123" could not be found.'
        );

        $this->controllerBehaviors->getParameter('abcdef0123');
    }

    public function testHasParameter()
    {
        static::assertTrue($this->controllerBehaviors->hasParameter('router.class'));
        static::assertFalse($this->controllerBehaviors->hasParameter('abcdef0123'));
    }

    public function testEm()
    {
        static::assertEquals($this->container->get(ControllerBehaviorsInterface::EM_DEFAULT_ID), $this->controllerBehaviors->em());
    }

    public function testEmSpecific()
    {
        static::assertEquals($this->container->get(ControllerBehaviorsInterface::EM_DEFAULT_ID), $this->controllerBehaviors->em('doctrine.orm.default_entity_manager'));
    }

    public function testEntityActionsSingleRollback()
    {
        $route = new Route();
        $route
            ->setSlug('name.of.route')
            ->setName('name.of.route')
            ->setParameters(['param1' => 1, 'param2' => 'a-string'])
            ->setDescription('Test route.')
            ;
        $this->controllerBehaviors->emTransactionBegin();
        $this->controllerBehaviors->entityPersist($route);
        $this->controllerBehaviors->emTransactionRollback();

        $routeRepo = $this
            ->controllerBehaviors
            ->em()
            ->getRepository('ScribeMantleBundle:Route\Route')
        ;

        $result = $routeRepo->findBySlug('name.of.route');
        static::assertEquals([], $result);
    }

    public function testEntityActionsSingle()
    {
        $route = new Route();
        $route
            ->setSlug('name.of.route')
            ->setName('name.of.route')
            ->setParameters(['param1' => 1, 'param2' => 'a-string'])
            ->setDescription('Test route.')
        ;
        $this->controllerBehaviors->emTransactionBegin();
        $this->controllerBehaviors->entityPersist($route);
        $this->controllerBehaviors->emTransactionCommit();
        $this->controllerBehaviors->emFlush();

        $routeRepo = $this
            ->controllerBehaviors
            ->em()
            ->getRepository('ScribeMantleBundle:Route\Route')
        ;

        $result = $routeRepo->findBySlug('name.of.route');
        static::assertEquals(1, count($result));

        $this->controllerBehaviors->entityRemove($result[0], true);

        $result = $routeRepo->findBySlug('name.of.route');
        static::assertEquals(0, count($result));
    }

    public function testEntityActionsCollectionRollback()
    {
        $route1 = new Route();
        $route1
            ->setSlug('name.of.route.1')
            ->setName('name.of.route.1')
            ->setParameters(['param1' => 1, 'param2' => 'a-string'])
            ->setDescription('Test route.')
        ;
        $route2 = new Route();
        $route2
            ->setName('name.of.route.2')
            ->setParameters(['param1' => 1, 'param2' => 'a-string'])
            ->setDescription('Test route.')
        ;
        $routeCollection = new ArrayCollection([$route1, $route2]);

        $this->setExpectedException(
            'Scribe\Doctrine\Exception\TransactionORMException'
        );
        $this->controllerBehaviors->entityCollectionPersist($routeCollection, true);

        $routeRepo = $this
            ->controllerBehaviors
            ->em()
            ->getRepository('ScribeMantleBundle:Route\Route')
        ;

        $result1 = $routeRepo->findBySlug('name.of.route.1');
        $result2 = $routeRepo->findBySlug('name.of.route.2');

        static::assertEquals([], $result1);
        static::assertEquals([], $result2);
    }

    public function testEntityActionsCollection()
    {
        $route1 = new Route();
        $route1
            ->setSlug('name.of.route.1')
            ->setName('name.of.route.2')
            ->setParameters(['param1' => 1, 'param2' => 'a-string'])
            ->setDescription('Test route.')
        ;
        $route2 = new Route();
        $route2
            ->setSlug('name.of.route.2')
            ->setName('name.of.route.2')
            ->setParameters(['param1' => 1, 'param2' => 'a-string'])
            ->setDescription('Test route.')
        ;
        $routeCollection = new ArrayCollection([$route1, $route2]);

        $this->controllerBehaviors->entityCollectionPersist($routeCollection, true);

        $routeRepo = $this
            ->controllerBehaviors
            ->em()
            ->getRepository('ScribeMantleBundle:Route\Route')
        ;

        $result1 = $routeRepo->findBySlug('name.of.route.1');
        $result2 = $routeRepo->findBySlug('name.of.route.2');

        static::assertEquals(1, count($result1));
        static::assertEquals(1, count($result2));

        $this->controllerBehaviors->entityCollectionRemove(new ArrayCollection([$result1[0], $result2[0]]), true);

        $result1 = $routeRepo->findBySlug('name.of.route.1');
        $result2 = $routeRepo->findBySlug('name.of.route.2');

        static::assertEquals(0, count($result1));
        static::assertEquals(0, count($result2));
    }

    public function testTemplating()
    {
        static::assertTrue($this->controllerBehaviors->templating() instanceof TwigEngine);
    }

    public function testTwig()
    {
        static::assertTrue($this->controllerBehaviors->twig() instanceof \Twig_Environment);
    }

    public function testTwigRenderString()
    {
        $template = '
            <ul>
            {% for item in itemCollection %}
                <li>{{ item }}</li>
            {% endfor %}
            </ul>
        ';
        $expected = '
            <ul>
                <li>One</li>
                <li>Two</li>
                <li>Three</li>
            </ul>
        ';

        static::assertXmlStringEqualsXmlString($expected, $this->controllerBehaviors->renderTwigStr(
            $template, ['itemCollection' => ['One', 'Two', 'Three']]
        ));
    }
}

/* EOF */
