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

use Scribe\Teavee\ObjectCacheBundle\DependencyInjection\Aware\CacheManagerAwareTrait;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Twig_Environment;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Scribe\WonkaBundle\Component\Templating\AbstractTwigExtension;

/**
 * Class ButtonRendererExtension.
 */
class ButtonRendererExtension extends AbstractTwigExtension
{
    use CacheManagerAwareTrait;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param Router     $router
     * @param Translator $translator
     */
    public function __construct(Router $router, Translator $translator)
    {
        parent::__construct();

        $this->router = $router;
        $this->translator = $translator;

        $this
            ->enableOptionHtmlSafe()
            ->enableOptionNeedsEnv()
            ->addFunction('text_button', [ $this, 'renderButton' ])
            ->addFunction('icon_button', [ $this, 'renderIconButton' ]);
    }

    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $what
     * @param string           $route
     * @param array            $routeArgs
     * @param string           $icon
     * @param array            $groupClasses
     * @param array            $btnClasses
     *
     * @return string
     */
    public function getButtonDeleteInHeader(Twig_Environment $twigEnvironment, $title, $what, $route = null, array $routeArgs = [],
                                            $icon = null, array $groupClasses = [], array $btnClasses = []
    ) {
        array_push($groupClasses, 'btn-group-in-header');
        array_push($groupClasses, 'pull-right');

        return $this->getButtonDelete($twigEnvironment, $title, $what, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }
    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $desc
     * @param string           $route
     * @param array            $routeArgs
     * @param string           $icon
     * @param string           $groupClasses
     * @param string           $btnClasses
     *
     * @return string
     */
    public function renderDefault(Twig_Environment $twigEnvironment, $title, $desc, $route, $routeArgs, $icon,
                                  $groupClasses, $btnClasses
    ) {
        $hrefReal = $route !== null ? $this->router->generate($route, $routeArgs) : '#';

        return $twigEnvironment->render('ScribeMantleBundle:Button:bs_btn_default.html.twig', [
            'title'        => $title,
            'desc'         => $desc,
            'url'          => $hrefReal,
            'icon'         => $icon,
            'groupClasses' => $groupClasses,
            'btnClasses'   => $btnClasses,
        ]);
    }
}

/* EOF */
