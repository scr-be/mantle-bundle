<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Aware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestAwareTrait.
 */
trait RequestStackAwareTrait
{
    /**
     * request stack instance.
     *
     * @var RequestStack|null
     */
    protected $requestStack = null;

    /**
     * Set request stack.
     *
     * @param $requestStack RequestStack
     *
     * @return $this
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        return $this;
    }

    /**
     * Get request stack.
     *
     * @return RequestStack|null
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }

    /**
     * Checks for request stack.
     *
     * @return bool
     */
    public function hasRequestStack()
    {
        return (bool) ($this->requestStack instanceof RequestStack);
    }

    /**
     * get request master.
     *
     * @return Request|null
     */
    public function getMasterRequest()
    {
        return $this->requestStack->getMasterRequest();
    }

    /**
     * get request current.
     *
     * @return Request|null
     */
    public function getCurrentRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Get the parent request.
     *
     * @return Request|null
     */
    public function getParentRequest()
    {
        return $this->requestStack->getParentRequest();
    }
}

/* EOF */
