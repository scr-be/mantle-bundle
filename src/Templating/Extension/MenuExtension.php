<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Extension;

use Scribe\MantleBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\MantleBundle\Templating\Extension\Part\ContainerAwareExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Twig_Extension;

/**
 * Class MenuExtension.
 */
class MenuExtension extends Twig_Extension
{
    use SimpleExtensionTrait,
        ContainerAwareExtensionTrait;

    /**
     * constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->init('menu');
    }

    /**
     * @param string $which
     *
     * @return mixed
     */
    public function menu($which)
    {
        $menu = $this
            ->getContainer()
            ->get('s.tpl.helper.menu')
        ;

        switch ($which) {
            case 'main':
                return $menu->renderHeader();
                break;

            case 'foot':
                return $menu->renderFooter();
                break;

            default:
                throw new InvalidArgumentException();
        }
    }
}
