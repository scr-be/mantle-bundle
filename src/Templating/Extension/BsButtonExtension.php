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

use Twig_Environment;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class BsButtonExtension.
 */
class BsButtonExtension extends AbstractTwigExtension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Initialize class instance and setup extension.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;

        $this
            ->enableOptionHtmlSafe()
            ->enableOptionNeedsEnv()
        ;

        $this->addFunction('bs_btn', [$this, 'getBootstrapButton']);
        $this->addFunction('bs_btn_default', [$this, 'getButtonDefault']);
        $this->addFunction('bs_btn_delete', [$this, 'getButtonDelete']);
        $this->addFunction('bs_btn_ajax_delete', [$this, 'getButtonAjaxDelete']);
        $this->addFunction('bs_btn_delete_in_hr', [$this, 'getButtonDeleteInHeader']);
        $this->addFunction('bs_btn_in_hr', [$this, 'getButtonInHeader']);
        $this->addFunction('bs_btn_cancel', [$this, 'getButtonAjaxDelete']);
        $this->addFunction('bs_btn_prev', [$this, 'getButtonPrevious']);
        $this->addFunction('bs_btn_next', [$this, 'getButtonNext']);
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
    public function getButtonDeleteInHeader(Twig_Environment $twigEnvironment, $title, $what, $route = null,
                                            array $routeArgs = [], $icon = null, array $groupClasses = [],
                                            array $btnClasses = [])
    {
        array_push($groupClasses, 'btn-group-in-header');
        array_push($groupClasses, 'pull-right');

        return $this->getButtonDelete($twigEnvironment, $title, $what, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
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
    public function getButtonDelete(Twig_Environment $twigEnvironment, $title, $what, $route = null,
                                    array $routeArgs = [], $icon = null, array $groupClasses = [],
                                    array $btnClasses = [])
    {
        if ($route !== null) {
            $data_href = $this->router->generate($route, $routeArgs);
            $url = '#';
        } else {
            $data_href = $url = '#';
        }

        if ($icon === null) {
            $icon = 'icon-minus-sign';
        }

        $desc = $title.' '.$what;
        array_push($btnClasses, 'btn-danger');

        return $twigEnvironment->render(
            'ScribeMantleBundle:Button:bs_btn_delete.html.twig',
            [
                'title' => $title,
                'desc' => $desc,
                'what' => $what,
                'data_href' => $data_href,
                'url' => $url,
                'icon' => $icon,
                'groupClasses' => $groupClasses,
                'btnClasses' => $btnClasses,
            ]
        );
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
    public function getButtonAjaxDelete(Twig_Environment $twigEnvironment, $title, $what, $route = null,
                                       array $routeArgs = [], $icon = null, $selector = null, array $groupClasses = [],
                                       array $btnClasses = [])
    {
        if ($route !== null) {
            $data_href = $this->router->generate($route, $routeArgs);
            $url = '#';
        } else {
            $data_href = $url = '#';
        }

        if ($icon === null) {
            $icon = 'icon-minus-sign';
        }

        $desc = $title.' '.$what;
        array_push($btnClasses, 'btn-danger');

        return $twigEnvironment->render(
            'ScribeMantleBundle:Button:bs_btn_ajax_delete.html.twig',
            [
                'title' => $title,
                'desc' => $desc,
                'what' => $what,
                'data_href' => $data_href,
                'url' => $url,
                'icon' => $icon,
                'groupClasses' => $groupClasses,
                'btnClasses' => $btnClasses,
                'selector' => $selector,
            ]
        );
    }

    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $desc
     * @param string           $route
     * @param array            $routeArgs
     * @param string           $icon
     * @param array            $groupClasses
     * @param array            $btnClasses
     *
     * @return string
     */
    public function getButtonCancel(Twig_Environment $twigEnvironment, $title, $desc, $route = null, array $routeArgs = [],
                                  $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        $icon = 'fa-reply';
        array_push($btnClasses, 'btn-warning');

        return $this->getButtonInHeader($twigEnvironment, $title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $desc
     * @param string           $route
     * @param array            $routeArgs
     * @param string           $icon
     * @param array            $groupClasses
     * @param array            $btnClasses
     *
     * @return string
     */
    public function getButtonInHeader(Twig_Environment $twigEnvironment, $title, $desc, $route = null, array $routeArgs = [],
                                 $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        $type = 'btn-default';
        array_push($groupClasses, 'btn-group-in-header');
        array_push($groupClasses, 'pull-right');

        return $this->getBootstrapButton($twigEnvironment, $title, $desc, $type, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $desc
     * @param string           $route
     * @param array            $routeArgs
     * @param string           $icon
     * @param array            $groupClasses
     * @param array            $btnClasses
     *
     * @return string
     */
    public function getButtonDefault(Twig_Environment $twigEnvironment, $title, $desc, $route = null, array $routeArgs = [],
                                   $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        $type = 'btn-default';

        return $this->getBootstrapButton($twigEnvironment, $title, $desc, $type, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $desc
     * @param string           $route
     * @param array            $routeArgs
     * @param string           $icon
     * @param array            $groupClasses
     * @param array            $btnClasses
     *
     * @return string
     */
    public function getBootstrapButton(Twig_Environment $twigEnvironment, $title, $desc, $type = 'btn-default', $route = null,
                           array $routeArgs = [], $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        array_push($btnClasses, $type);

        return $this->renderDefault($twigEnvironment, $title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $desc
     * @param string           $route
     * @param array            $routeArgs
     * @param array            $groupClasses
     * @param array            $btnClasses
     *
     * @return string
     */
    public function getButtonNext(Twig_Environment $twigEnvironment, $title, $desc, $route = null, array $routeArgs = [],
                                array $groupClasses = [], array $btnClasses = [])
    {
        array_push($btnClasses, 'btn-default');
        $icon = 'fa-angle-right';

        return $this->renderPrevNext($twigEnvironment, $title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses, 'next');
    }

    /**
     * @param Twig_Environment $twigEnvironment
     * @param string           $title
     * @param string           $desc
     * @param string           $route
     * @param array            $routeArgs
     * @param array            $groupClasses
     * @param array            $btnClasses
     *
     * @return string
     */
    public function getButtonPrevious(Twig_Environment $twigEnvironment, $title, $desc, $route = null, array $routeArgs = [],
                                array $groupClasses = [], array $btnClasses = [])
    {
        array_push($btnClasses, 'btn-default');
        $icon = 'fa-angle-left';

        return $this->renderPrevNext($twigEnvironment, $title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses, 'prev');
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
     * @param string|null      $direction
     *
     * @return string
     */
    public function renderPrevNext(Twig_Environment $twigEnvironment, $title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses, $direction = null)
    {
        if ($route !== null) {
            $url = $this->router->generate($route, $routeArgs);
        } else {
            $url = '#';
        }

        return $twigEnvironment->render(
            'ScribeMantleBundle:Button:bs_btn_prevnext.html.twig',
            [
                'title' => $title,
                'desc' => $desc,
                'url' => $url,
                'icon' => $icon,
                'groupClasses' => $groupClasses,
                'btnClasses' => $btnClasses,
                'direction' => $direction,
            ]
        );
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
    public function renderDefault(Twig_Environment $twigEnvironment, $title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses)
    {
        if ($route !== null) {
            $url = $this->router->generate($route, $routeArgs);
        } else {
            $url = '#';
        }

        return $twigEnvironment->render(
            'ScribeMantleBundle:Button:bs_btn_default.html.twig',
            [
                'title' => $title,
                'desc' => $desc,
                'url' => $url,
                'icon' => $icon,
                'groupClasses' => $groupClasses,
                'btnClasses' => $btnClasses,
            ]
        );
    }
}
