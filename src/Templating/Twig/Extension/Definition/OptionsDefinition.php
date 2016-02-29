<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Twig\Extension\Options;

/**
 * Class OptionsDefinition.
 */
abstract class OptionsDefinition implements OptionsDefinitionInterface
{
    /**
     * Options that are globally applied to all filters and functions for this extension.
     *
     * @var array[]
     */
    private $optionCollection = [];

    /**
     * @param array $optionCollection
     */
    public function __construct(array $optionCollection = [])
    {
        if (is_iterable_not_empty($optionCollection)) {
            $this->setOptionCollection($optionCollection);
        }
    }

    /**
     * @return $this
     */
    public function clearOptions()
    {
        $this->optionCollection = [];

        return $this;
    }

    /**
     * @param array $option
     *
     * @return $this
     */
    public function setOption($option)
    {
        return $this->setOptionCollection([$option]);
    }

    /**
     * @param array[] $optionCollection
     *
     * @return $this
     */
    public function setOptionCollection(array ...$optionCollection)
    {
        return $this
            ->clearOptions()
            ->stackOptions($optionCollection);
    }

    /**
     * @param array $option
     *
     * @return $this
     */
    public function addOption($option)
    {
        return $this->addOptionCollection([$option]);
    }

    /**
     * @param array[] $optionCollection
     *
     * @return $this
     */
    public function addOptionCollection(array ...$optionCollection)
    {
        return $this->stackOptions($optionCollection);
    }

    /**
     * @return $this
     */
    public function enableOptionNeedsEnv()
    {
        $this->addOptionCollection(['needs_environment' => true]);

        return $this;
    }

    /**
     * Sets the option that allows for HTML to be returned from the extension function.
     *
     * @return $this
     */
    public function enableOptionHtmlSafe()
    {
        $this->addOptionCollection(['is_safe' => ['html']]);

        return $this;
    }

    /**
     * @param array $optionCollection
     *
     * @return $this
     */
    protected function stackOptions(array $optionCollection)
    {
        foreach ($optionCollection as $option) {
            if (isEmptyIterable($option)) {
                continue;
            }

            $this->optionCollection[(string) key($option)] = current($option);
        }

        return $this;
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return array|\array[]
     */
    private function resolvedOptions($type, $name)
    {
        $optionCollection = $this->optionCollection;
        $typeOptionCollectionName = $type.self::PROPERTY_PART_OPTION;

        if (array_key_exists($name, $this->functionCallableCollection)) {
            $optionCollection = array_merge(
                $optionCollection,
                $this->{$typeOptionCollectionName}[$name]
            );
        }

        return $optionCollection;
    }

    /**
     * Add a Twig function to this extension.
     *
     * @param string   $name
     * @param callable $method
     * @param array    $optionCollection
     *
     * @return $this
     */
    public function addFunction($name, callable $method, array $optionCollection = [])
    {
        return $this
            ->stackCallable(__FUNCTION__, $name, $method, $optionCollection);
    }

    /**
     * Add a Twig filter to this extension.
     *
     * @param string   $name
     * @param callable $method
     * @param array    $optionCollection
     *
     * @return $this
     */
    public function addFilter($name, callable $method, array $optionCollection = [])
    {
        return $this
            ->stackCallable(__FUNCTION__, $name, $method, $optionCollection);
    }

    /**
     * Internal common implementation for {@see addFunction()} and {@see addFilter()}.
     *
     * @param string   $type
     * @param string   $name
     * @param callable $method
     * @param array    $optionCollection
     *
     * @return $this
     */
    private function stackCallable($type, $name, callable $method, array $optionCollection)
    {
        $this
            ->validateName($name)
            ->validateType($type);

        $optionVariableString = $type.self::PROPERTY_PART_OPTION;
        $methodVariableString = $type.self::PROPERTY_PART_METHOD;

        $this->{$optionVariableString}[$name] = $optionCollection;
        $this->{$methodVariableString}[$name] = $method;

        return $this;
    }

    /**
     * Validate and get the proper call type.
     *
     * @param mixed $type
     *
     * @return $this
     */
    private function validateType(&$type)
    {
        $this->validateName($type);
        $type = strtolower(substr($type, 3));

        return $this;
    }

    /**
     * Verify that a string was passed as the filter/function name.
     *
     * @param mixed $name
     *
     * @return $this
     */
    private function validateName($name)
    {
        if (true === is_string($name)) {
            return $this;
        }

        throw new RuntimeException(
            'Invalid function/filter name provided to $s (you must provide a string).', null, null, __METHOD__
        );
    }

    /**
     * @param string $type
     *
     * @return array
     */
    private function getCallableCollectionForType($type)
    {
        $this->validateType($type);
        $type = substr($type, 0, strlen($type) - 1);

        $callableCollection = [];
        $callableCollectionName = $type.self::PROPERTY_PART_METHOD;
        $twigExtensionClassName = 'Twig_Simple'.ucfirst($type);

        if (false === is_array($this->{$callableCollectionName}) || 0 === count($this->{$callableCollectionName})) {
            return $callableCollection;
        }

        foreach ($this->{$callableCollectionName} as $name => $callable) {
            $callableCollection[$name] = new $twigExtensionClassName(
                $name, $callable, $this->resolvedOptions($type, $name)
            );
        }

        return $callableCollection;
    }

    /**
     * Returns an array of {@see Twig_SimpleFunction} instances, providing the beidge between twig function calls
     * and the methods in this class.
     *
     * @return array
     */
    public function getFunctions()
    {
        return $this->getCallableCollectionForType(__FUNCTION__);
    }

    /**
     * Returns an array of {@see Twig_SimpleFilter} instances, providing the beidge between twig function calls
     * and the methods in this class.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->getCallableCollectionForType(__FUNCTION__);
    }

    /**
     * Returns the name of the Twig extension based on the classname.
     *
     * @return string
     */
    final public function getName()
    {
        return strtolower(sprintf('s.twig_extension.%s', ClassInfo::getClassNameByInstance($this)));
    }
}

/* EOF */
