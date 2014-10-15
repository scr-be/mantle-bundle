<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestAwareTrait
 *
 * @package Scribe\SharedBundle\DependencyInjection
 */
trait RequestAwareTrait
{
    /**
     * request instance
     *
     * @var Request|null
     */
    protected $request = null;

    /**
     * Setter for request property from container
     *
     * @param ContainerInterface $container container object
     */
    public function setRequestFromContainer(ContainerInterface $container)
    {
        $this->setRequest($container->get('request'));
    }

    /**
     * Setter for request
     *
     * @param  Request|null $request request instance
     * @return $this
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Getter for request
     *
     * @return Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get request referer
     *
     * @param  string $default the default referer to return if none found
     * @return string|null
     */
    public function getReferer($default = null)
    {
        return $this
            ->getRequest()
            ->headers
            ->get('referer', $default)
        ;
    }
}
