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
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Bridge\Twig\TwigEngine;
use Twig_Extension;
use Twig_Environment;

/**
 * Class IconCreatorExtension.
 */
class IconCreatorExtension extends Twig_Extension
{
    use AdvancedExtensionTrait;

    /**
     * @var IconCreatorInterface
     */
    private $iconCreator;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(IconCreatorInterface $iconCreator)
    {
        $this->iconCreator = $iconCreator;

        $this->setParameters([
            'is_safe'           => [ 'html' ],
            'needs_environment' => true,
        ]);

        $this->addFunctionMethod('getIcon', 'get_icon');
    }

    /**
     * @param Twig_Environment $env
     * @param string           $icon
     * @param string|null      $family
     * @param string|null      $template
     * @param ...string        $styles
     *
     * @return string
     */
    public function getIcon(Twig_Environment $env, $icon, $family = null, $template = null, ...$styles)
    {
        if (false === $this->iconCreator->hasEngine()) {
            $engine = $this->buildEngineInterfaceFromTwigEnvironment($env);
            $this->iconCreator->setEngine($engine);
        }

        return (string) $this->iconCreator->render($icon, $family, $template, ...$styles);
    }

    /**
     * @param Twig_Environment $env
     *
     * @return TwigEngine
     */
    protected function buildEngineInterfaceFromTwigEnvironment(Twig_Environment $env)
    {
        $nameParser = new TemplateNameParser();
        $engine     = new TwigEngine($env, $nameParser);

        return $engine;
    }
}

/* EOF */
