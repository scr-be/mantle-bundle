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

use Scribe\MantleBundle\Templating\Extension\Part\AdvancedExtensionTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;

/**
 * Class IconExtension
 */
class IconExtension extends Twig_Extension
{
    use AdvancedExtensionTrait;

    /**
     * @var IconCreatorInterface
     */
    private $iconCreator;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->iconCreator = $container->get('s.mantle.iconcreator');

        $this->addFunctionMethod('getIcon', 'get_icon');
    }

    /**
     * @return string
     */
    public function getIcon($icon, $family = null, $template = null, ...$styles)
    {
        return $this->iconCreator->render($icon, $family, $template, ...$styles);
    }

}

/* EOF */
