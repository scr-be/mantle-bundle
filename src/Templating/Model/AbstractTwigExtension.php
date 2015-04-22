<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Model;

use Scribe\Utility\ClassInfo;

/**
 * Class AbstractTwigExtension.
 */
abstract class AbstractTwigExtension extends \Twig_Extension implements TwigExtensionInterface
{
    /**
     * An array of callbacks that will be passed as
     *
     * @var array
     */
    private $functionCallbackCollection;

    /**
     * An array of the internal
     */
    /**
     * @var array
     */
    private $functionMethods = [];

    /**
     * @var array
     */
    private $filterMethods = [];

    /**
     * @var array
     */
    private $parameters = ['is_safe' => ['html']];

    /**
     * Provides the name of the
     *
     * @return string
     */
    final public function getName()
    {
        return ClassInfo::getClassNameByInstance($this);
    }

    /**
     * @param array $methods
     *
     * @return $this
     */
    public function setFunctionMethods(array $methods = [])
    {
        $this->functionMethods = $this->cleanupMethodsArray($methods);

        return $this;
    }

    /**
     * @return array
     */
    public function getFunctionMethods()
    {
        return (array) $this->functionMethods;
    }

    /**
     * @param string $internal
     * @param string $external
     *
     * @return $this
     */
    public function addFunctionMethod($internal, $external)
    {
        $this->setFunctionMethods(
            array_merge(
                [$internal => $external],
                $this->getFunctionMethods()
            )
        );

        return $this;
    }

    /**
     * @param array $methods
     *
     * @return $this
     */
    public function setFilterMethods(array $methods = [])
    {
        $this->filterMethods = $this->cleanupMethodsArray($methods);

        return $this;
    }

    /**
     * @return array
     */
    public function getFilterMethods()
    {
        return (array) $this->filterMethods;
    }

    /**
     * @param string $internal
     * @param string $external
     *
     * @return $this
     */
    public function addFilterMethod($internal, $external)
    {
        $this->setFilterMethods(
            array_merge(
                [$internal => $external],
                $this->getFilterMethods()
            )
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return (array) $this->parameters;
    }

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function setParameters(array $parameters = [])
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return TemplatingEngine
     */
    private function getEngine()
    {
        return $this->container->get('templating');
    }

    /**
     * @param array $methods
     *
     * @return array
     */
    private function cleanupMethodsArray(array $methods = [])
    {
        $methodsParsed = [];

        foreach ($methods as $internalMethod => $externalMethod) {
            if (is_int($internalMethod)) {
                $internalMethod = $externalMethod;
            }
            $methodsParsed[$internalMethod] = $externalMethod;
        }

        return $methodsParsed;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        $functions = [];

        foreach ($this->getFunctionMethods() as $internal => $external) {
            $functions[$external] = new Twig_Function_Method(
                $this,
                $internal,
                $this->getParameters()
            );
        }

        return $functions;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        $filters = [];

        foreach ($this->getFilterMethods() as $internal => $external) {
            $filters[$external] = new Twig_Filter_Method(
                $this,
                $internal,
                $this->getParameters()
            );
        }

        return $filters;
    }
}
