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
use Scribe\SharedBundle\Templating\Helper\Menu\MenuContainer;

/**
 * Class MenuFactory
 */
class MenuFactory implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface|null
     */
    private $container = null;

    /**
     * @var Menu
     */
    private $menu;

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

    public function getMenu()
    {
        $menuHandler = $this
            ->container
            ->get('s.tpl.helper.menu.handler')
        ;

        list($security, $services, $header, $footer, $settings) = $menuHandler->getMenus();

        $engine = $this
            ->container
            ->get('templating')
        ;
        $em = $this
            ->container
            ->get('doctrine.orm.default_entity_manager')
        ;
        $bundleInfo = $this
            ->container
            ->get('doctrine.orm.default_entity_manager')
        ;

        $menu = new MenuContainer($engine, $em);
        $menu
            ->setMenuSecurity($security)
            ->setMenuServices($services)
            ->setMenuHeader($header)
            ->setMenuFooter($footer)
            ->setMenuSettings($settings)
        ;

        return $menu;
    }
}
