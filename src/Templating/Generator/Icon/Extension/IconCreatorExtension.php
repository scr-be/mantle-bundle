<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Icon\Extension;

use Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorInterface;
use Twig_Environment;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class IconCreatorExtension.
 */
class IconCreatorExtension extends AbstractTwigExtension
{
    /**
     * @var IconCreatorInterface|IconCreatorInterface
     */
    private $iconCreator;

    /**
     * @param IconCreatorInterface $iconCreator
     */
    public function __construct(IconCreatorInterface $iconCreator)
    {
        parent::__construct();

        $this->iconCreator = $iconCreator;

        $this
            ->enableOptionHtmlSafe()
            ->enableOptionNeedsEnv()
        ;

        $this
            ->addFunction('get_icon', [$this, 'getIconDeprecated'])
            ->addFunction('icon', [$this, 'getIcon'])
            ->addFunction('get_icon_enviornment', [$this, 'getIconCreator'])
        ;
    }

    /**
     * @return IconCreatorInterface
     */
    public function getIconCreator()
    {
        return $this->iconCreator;
    }

    /**
     * @param Twig_Environment $engine
     *
     * @return $this
     */
    protected function setTwigEnviornmentWithinIconCreator(Twig_Environment $engine)
    {
        if (false === $this->getIconCreator()->hasEngineEnvironment()) {
            $this->getIconCreator()->setEngineEnvironment($engine);
        }

        return $this;
    }

    /**
     * @param Twig_Environment $engineEnvironment
     * @param string           $icon
     * @param string|null      $family
     * @param string|null      $template
     * @param ...string        $styles
     *
     * @return string
     */
    public function getIconDeprecated(Twig_Environment $engineEnvironment, $icon, $family = null, $template = null, ...$styles)
    {
        return (string) $this
            ->setTwigEnviornmentWithinIconCreator($engineEnvironment)
            ->getIconCreator()
            ->setTemplate($template)
            ->render($icon, $family, ...$styles)
        ;
    }

    /**
     * @param Twig_Environment $engineEnvironment
     * @param string           $icon
     * @param string|null      $family
     * @param ...string        $styles
     *
     * @return string
     */
    public function getIcon(Twig_Environment $engineEnvironment, $icon, $family = null, ...$styles)
    {
        return (string) $this
            ->setTwigEnviornmentWithinIconCreator($engineEnvironment)
            ->getIconCreator()
            ->render($icon, $family, ...$styles)
        ;
    }
}

/* EOF */
