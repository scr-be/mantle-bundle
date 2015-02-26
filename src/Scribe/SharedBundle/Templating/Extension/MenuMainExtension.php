<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\ContainerAwareExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;

/**
 * Class MenuExtension
 */
class MenuMainExtension extends Twig_Extension
{
    use ContainerAwareExtensionTrait;

    /**
     * constructor
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'menu_main' => new \Twig_Function_Method(
                $this,
                'renderMenuMain',
                ['is_safe' => ['html']]
            ),
            'menu_foot' => new \Twig_Function_Method(
                $this,
                'renderMenuFoot',
                ['is_safe' => ['html']]
            )

        ];
    }

    public function getName()
    {
        return get_class();
    }
}
