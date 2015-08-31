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

use Scribe\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestStackAwareTrait.
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
     * @return bool
     */
    public function hasMasterRequest()
    {
        return (bool) ($this->getMasterRequest() instanceof Request);
    }

    /**
     * @param string $parameterBag
     * @param string $index
     *
     * @return bool
     */
    public function hasMasterRequestParameterBagIndex($parameterBag, $index)
    {
        return (bool) $this->hasRequestParameterBagIndex('master', $parameterBag, $index);
    }

    /**
     * @param string $parameterBag
     * @param string $index
     *
     * @return mixed
     */
    public function getMasterRequestParameterBagIndexValue($parameterBag, $index)
    {
        return $this->getRequestParameterBagIndexValue('master', $parameterBag, $index);
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
     * @return bool
     */
    public function hasCurrentRequest()
    {
        return (bool) ($this->getCurrentRequest() instanceof Request);
    }

    /**
     * @param string $parameterBag
     * @param string $index
     *
     * @return bool
     */
    public function hasCurrentRequestParameterBagIndex($parameterBag, $index)
    {
        return (bool) $this->hasRequestParameterBagIndex('current', $parameterBag, $index);
    }

    /**
     * @param string $parameterBag
     * @param string $index
     *
     * @return mixed
     */
    public function getCurrentRequestParameterBagIndexValue($parameterBag, $index)
    {
        return $this->getRequestParameterBagIndexValue('current', $parameterBag, $index);
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

    /**
     * @return bool
     */
    public function hasParentRequest()
    {
        return (bool) ($this->getParentRequest() instanceof Request);
    }

    /**
     * @param string $parameterBag
     * @param string $index
     *
     * @return bool
     */
    public function hasParentRequestParameterBagIndex($parameterBag, $index)
    {
        return (bool) $this->hasRequestParameterBagIndex('parent', $parameterBag, $index);
    }

    /**
     * @param string $parameterBag
     * @param string $index
     *
     * @return mixed
     */
    public function getParentRequestParameterBagIndexValue($parameterBag, $index)
    {
        return $this->getRequestParameterBagIndexValue('parent', $parameterBag, $index);
    }

    /**
     * @param string $requestType
     * @param string $parameterBag
     * @param string $index
     *
     * @return bool
     */
    protected function hasRequestParameterBagIndex($requestType, $parameterBag, $index)
    {
        $method = $this->normalizeRequestTypeMagicMethodName('has', $requestType);

        try {
            return (bool) $this->requestStack->$method->$parameterBag->has($index);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param string $requestType
     * @param string $parameterBag
     * @param string $index
     *
     * @return mixed
     */
    protected function getRequestParameterBagIndexValue($requestType, $parameterBag, $index)
    {
        $method = $this->normalizeRequestTypeMagicMethodName('get', $requestType);

        try {
            return $this->requestStack->$method->$parameterBag->get($index);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param string $action
     * @param string $requestType
     *
     * @return string
     */
    protected function normalizeRequestTypeMagicMethodName($action, $requestType)
    {
        $methodName = $action . ucwords($requestType) . 'Request';

        if (null === ($method = preg_replace('#[^a-zA-Z]#', '', $methodName))) {
            throw new LogicException('Invalid resulting magic method name for %s in %s.', null, null, null, $methodName, __METHOD__);
        }

        return $method;
    }

    /**
     * @return null|Request
     */
    protected function popRequestFromStack()
    {
        return $this->requestStack->pop();
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    protected function pushRequestOntoStack(Request $request)
    {
        $this->requestStack->push($request);

        return $this;
    }
}

/* EOF */
