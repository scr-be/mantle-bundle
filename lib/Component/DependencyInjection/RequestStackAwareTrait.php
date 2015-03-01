<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestAwareTrait
 *
 * @package Scribe\MantleBundle\DependencyInjection
 */
trait RequestStackAwareTrait
{
    use RequestAwareTrait;

    /**
     * request stack instance
     *
     * @var RequestStack|null
     */
    protected $requestStack = null;

    /**
     * master request instance
     *
     * @var Request|null
     */
    protected $requestMaster = null;

    /**
     * Set the request stack and determine the master and current requests
     * @param RequestStack $requestStack
     */
    public function setRequestStackAndDetermineMasterAndCurrentRequest(RequestStack $requestStack)
    {
        $this
            ->setRequestStack($requestStack)
            ->determineRequestMasterFromRequestStack()
            ->determineRequestCurrentFromRequestStack()
        ;
    }

    /**
     * set request stack
     *
     * @param  $requestStack RequestStack
     * @return $this
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        return $this;
    }

    /**
     * get request stack
     *
     * @return RequestStack|null
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }

    /**
     * checks if request stack is set
     *
     * @return bool
     */
    public function hasRequestStack()
    {
        return (bool) ($this->requestStack instanceof RequestStack);
    }

    /**
     * set request master
     *
     * @param  $requestMaster Request
     * @return $this
     */
    public function setRequestMaster(Request $requestMaster)
    {
        $this->requestMaster = $requestMaster;

        return $this;
    }

    /**
     * get request master
     *
     * @return Request|null
     */
    public function getRequestMaster()
    {
        return $this->requestMaster;
    }

    /**
     * checks if request master is set
     *
     * @return bool
     */
    public function hasRequestMaster()
    {
        return (bool) ($this->requestMaster instanceof Request);
    }

    /**
     * set request current
     *
     * @param  $request Request
     * @return $this
     */
    public function setRequestCurrent(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * get request current
     *
     * @return Request|null
     */
    public function getRequestCurrent()
    {
        return $this->request;
    }

    /**
     * checks if request current is set
     *
     * @return bool
     */
    public function hasRequestCurrent()
    {
        return (bool) ($this->request instanceof Request);
    }

    /**
     * Determine the master request from the request stack
     * @return $this
     */
    public function determineRequestMasterFromRequestStack()
    {
        $this->requestMaster = $this->requestStack->getMasterRequest();

        return $this;
    }

    /**
     * Determine the current request from the request stack
     * @return $this
     */
    public function determineRequestCurrentFromRequestStack()
    {
        $this->request = $this->requestStack->getCurrentRequest();

        return $this;
    }


    /**
     * Sets the request stack from a passed service container object
     *
     * @param ContainerInterface $container container object
     * @return $this
     */
    public function setRequestStackFromContainer(ContainerInterface $container)
    {
        $this->requestStack = $container->get('request_stack');

        return $this;
    }
}
