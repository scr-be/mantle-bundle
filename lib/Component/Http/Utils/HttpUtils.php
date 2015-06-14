<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Http\Utils;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Scribe\Exception\RuntimeException;
use Scribe\Component\DependencyInjection\Aware\RequestStackAwareTrait;
use Scribe\Component\DependencyInjection\Aware\RouterAwareTrait;

/**
 * Class HttpUtils.
 */
class HttpUtils
{
    use RequestStackAwareTrait,
        RouterAwareTrait;

    /**
     * @var string
     */
    protected $redirect;

    /**
     * @param RequestStack    $requestStack
     * @param RouterInterface $router
     */
    public function __construct(RequestStack $requestStack, RouterInterface $router)
    {
        $this
            ->setRequestStack($requestStack)
            ->setRouter($router)
        ;
    }

    /**
     * @param RequestStack    $requestStack
     * @param RouterInterface $router
     *
     * @return HttpUtils
     */
    public static function getInstance(RequestStack $requestStack, RouterInterface $router)
    {
        return new self($requestStack, $router);
    }

    /**
     * @return string
     */
    public function getRedirect()
    {
        return (string) $this->redirect;
    }

    /**
     * @param $redirectUrl
     *
     * @return $this
     */
    public function setRedirect($redirectUrl)
    {
        $this->redirect = (string) $redirectUrl;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasRedirect()
    {
        return (bool) $this->redirect !== null ?: false;
    }

    /**
     * @param string|null $fallbackRouteIndex
     * @param array       $fallbackRouteArguments
     *
     * @return $this
     */
    public function setRedirectFromReferrer($fallbackRouteIndex = null, array $fallbackRouteArguments = [])
    {
        if (false !== ($referrer = $this->getReferrer())) {
            $this->setRedirect(
                $referrer
            );
        } elseif (null !== $fallbackRouteIndex) {
            $this->setRedirect(
                $this->getRouteUrl($fallbackRouteIndex, $fallbackRouteArguments)
            );
        } else {
            throw new RuntimeException(
                'No HTTP referer present in request and no default provided in "%s".', null, null, null, __METHOD__
            );
        }

        return $this;
    }

    /**
     * @return bool|string
     */
    public function getReferrer()
    {
        $master = $this->getRequestStack()->getMasterRequest();

        return $master->request->has('referer') ? $master->request->get('referer') : false;
    }

    /**
     * @param string $route
     * @param array  $arguments
     *
     * @return string
     */
    public function getRouteUrl($route, array $arguments = [])
    {
        return $this->getRouter()->generate($route, $arguments);
    }
}

/* EOF */
