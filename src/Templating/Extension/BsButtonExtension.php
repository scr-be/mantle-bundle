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
use Twig_Extension;

/**
 * Class BsButtonExtension.
 */
class BsButtonExtension extends Twig_Extension
{
    use SimpleExtensionTrait,
        ContainerAwareExtensionTrait;

    /**
     * constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->init('bs_btn');
    }

    public function bs_btn_delete_in_hr($title, $what, $route = null, array $routeArgs = [], $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        array_push($groupClasses, 'btn-group-in-header');
        array_push($groupClasses, 'pull-right');

        return $this->bs_btn_delete($title, $what, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    public function bs_btn_delete($title, $what, $route = null, array $routeArgs = [], $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        $engine = $this->getContainer()->get('templating');
        $routing = $this->getContainer()->get('router');

        if ($route !== null) {
            $data_href = $routing->generate($route, $routeArgs);
            $url = '#';
        } else {
            $data_href = $url = '#';
        }

        if ($icon === null) {
            $icon = 'icon-minus-sign';
        }

        $desc = $title.' '.$what;
        array_push($btnClasses, 'btn-danger');

        $out = $engine->render(
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

        return $out;
    }

    public function bs_btn_ajax_delete($title, $what, $route = null, array $routeArgs = [], $icon = null, $selector = null, array $groupClasses = [], array $btnClasses = [])
    {
        $engine = $this->getContainer()->get('templating');
        $routing = $this->getContainer()->get('router');

        if ($route !== null) {
            $data_href = $routing->generate($route, $routeArgs);
            $url = '#';
        } else {
            $data_href = $url = '#';
        }

        if ($icon === null) {
            $icon = 'icon-minus-sign';
        }

        $desc = $title.' '.$what;
        array_push($btnClasses, 'btn-danger');

        $out = $engine->render(
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

        return $out;
    }

    public function bs_btn_cancel($title, $desc, $route = null, array $routeArgs = [], $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        $icon = 'fa-reply';
        array_push($btnClasses, 'btn-warning');

        return $this->bs_btn_in_hr($title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    /**
     * @param string $icon
     */
    public function bs_btn_in_hr($title, $desc, $route = null, array $routeArgs = [], $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        $type = 'btn-default';
        array_push($groupClasses, 'btn-group-in-header');
        array_push($groupClasses, 'pull-right');

        return $this->bs_btn($title, $desc, $type, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    public function bs_btn_default($title, $desc, $route = null, array $routeArgs = [], $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        $type = 'btn-default';

        return $this->bs_btn($title, $desc, $type, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    public function bs_btn($title, $desc, $type = 'btn-default', $route = null, array $routeArgs = [], $icon = null, array $groupClasses = [], array $btnClasses = [])
    {
        array_push($btnClasses, $type);

        return $this->renderDefault($title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses);
    }

    public function bs_btn_next($title, $desc, $route = null, array $routeArgs = [], array $groupClasses = [], array $btnClasses = [])
    {
        array_push($btnClasses, 'btn-default');
        $icon = 'fa-angle-right';

        return $this->renderPrevNext($title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses, 'next');
    }

    public function bs_btn_prev($title, $desc, $route = null, array $routeArgs = [], array $groupClasses = [], array $btnClasses = [])
    {
        array_push($btnClasses, 'btn-default');
        $icon = 'fa-angle-left';

        return $this->renderPrevNext($title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses, 'prev');
    }

    /**
     * @param string $icon
     * @param string $direction
     */
    public function renderPrevNext($title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses, $direction = null)
    {
        $engine = $this
            ->getContainer()
            ->get('templating')
        ;
        $routing = $this
            ->getContainer()
            ->get('router')
        ;

        if ($route !== null) {
            $url = $routing->generate($route, $routeArgs);
        } else {
            $url = '#';
        }

        $out = $engine->render(
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

        return $out;
    }

    public function renderDefault($title, $desc, $route, $routeArgs, $icon, $groupClasses, $btnClasses)
    {
        $engine = $this
            ->getContainer()
            ->get('templating')
        ;
        $routing = $this
            ->getContainer()
            ->get('router')
        ;

        if ($route !== null) {
            $url = $routing->generate($route, $routeArgs);
        } else {
            $url = '#';
        }

        $out = $engine->render(
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

        return $out;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            $this->getExternalTwigMethodName() => new \Twig_Function_Method(
                $this,
                $this->getInternalTwigMethodName(),
                ['is_safe' => ['html']]
            ),
            'bs_btn_default' => new \Twig_Function_Method(
                $this,
                'bs_btn_default',
                ['is_safe' => ['html']]
            ),
            'bs_btn_delete' => new \Twig_Function_Method(
                $this,
                'bs_btn_delete',
                ['is_safe' => ['html']]
            ),
            'bs_btn_ajax_delete' => new \Twig_Function_Method(
                $this,
                'bs_btn_ajax_delete',
                ['is_safe' => ['html']]
            ),
            'bs_btn_delete_in_hr' => new \Twig_Function_Method(
                $this,
                'bs_btn_delete_in_hr',
                ['is_safe' => ['html']]
            ),
            'bs_btn_in_hr' => new \Twig_Function_Method(
                $this,
                'bs_btn_in_hr',
                ['is_safe' => ['html']]
            ),
            'bs_btn_cancel' => new \Twig_Function_Method(
                $this,
                'bs_btn_cancel',
                ['is_safe' => ['html']]
            ),
            'bs_btn_prev' => new \Twig_Function_Method(
                $this,
                'bs_btn_prev',
                ['is_safe' => ['html']]
            ),
            'bs_btn_next' => new \Twig_Function_Method(
                $this,
                'bs_btn_next',
                ['is_safe' => ['html']]
            ),
        ];
    }
}
