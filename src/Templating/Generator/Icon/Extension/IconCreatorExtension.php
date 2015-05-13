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

use Twig_Environment;
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreator;
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorInterface;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class IconCreatorExtension.
 */
class IconCreatorExtension extends AbstractTwigExtension
{
    /**
     * @var IconCreator|IconCreatorInterface
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

        $this->addFunction('get_icon', [$this, 'getIcon']);
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
    public function getIcon(Twig_Environment $engineEnvironment, $icon, $family = null, $template = null, ...$styles)
    {
        if (false === $this->iconCreator->hasEngineEnvironment()) {
            $this->iconCreator->setEngineEnvironment($engineEnvironment);
        }

        return (string) $this->iconCreator->render($icon, $family, $template, ...$styles);
    }
}

/* EOF */
