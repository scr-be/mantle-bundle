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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\Component\DependencyInjection\ContainerAwareTrait;
use Scribe\Exception\RuntimeException;

/**
 * Class AbstractExtension
 *
 * @package Scribe\Component\DependencyInjection
 */
abstract class AbstractExtension extends Extension implements ContainerAwareInterface
{
    /**
     * Import container aware properties/functions
     */
    use ContainerAwareTrait;

    /**
     * Index prefix property
     *
     * @var string
     */
    private $indexPrefix = 'scribe';

    /**
     * Index parts separator
     *
     * @var string
     */
    private $indexSeparator = '.';

    /**
     * Setter for index prefix
     *
     * @param  string $indexPrefix prefix for paramiter keys (indexes)
     * @return $this
     */
    protected function setIndexPrefix($indexPrefix)
    {
        $this->indexPrefix = (string)$indexPrefix;

        return $this;
    }

    /**
     * Getter for index prefix
     *
     * @return string
     */
    protected function getIndexPrefix()
    {
        return (string)$this->indexPrefix;
    }

    /**
     * Setter for index parts separator
     *
     * @param  string $indexSeparator prefix for paramiter index separator
     * @return $this
     */
    protected function setIndexSeparator($indexSeparator)
    {
        $this->indexSeparator = (string)$indexSeparator;

        return $this;
    }

    /**
     * Getter for index parts separator
     *
     * @return string
     */
    protected function getIndexSeparator()
    {
        return (string)$this->indexSeparator;
    }

    /**
     * Loads the configuration as defined in {@see Configuration.php}
     *
     * @param  array            $configs   collection of configs to load
     * @param  ContainerBuilder $container symfony config container
     * @return void
     */
    abstract public function load(array $configs, ContainerBuilder $container);

    /**
     * Process config array to container perameter key=>values
     *
     * @param  array  $config      configuration array
     * @param  string $outerIndex  concatinated index
     * @return $this
     */
    protected function processConfigToParameter(array $config = [], $outerIndex = null)
    {
        if (0 === sizeof($config)) {
            $this->handleConfigAsEmptyToParameter($outerIndex, $config);
            return $this;
        }

        foreach ($config as $index => $value) {
            $builtIndex = $this->buildParameterIndex($outerIndex, $index);

            if (is_array($value) && false === $this->isHash($value)) {
                $this->handleConfigAsIntArrayToParameter($builtIndex, $value);
            }
            elseif (is_array($value)) {
                $this->processConfigToParameter($value, $outerIndex . '.' . $index);
            }
            else {
                $this->handleConfigToParameter($builtIndex, $value);
            }
        }

        return $this;
    }

    /**
     * Process and assign a parameter config value when it is a yaml list, which
     * is translated to a non-hash (integer-key-based) array and assign the
     * parameter value, merging any previous entries in the array.
     *
     * @param  string $index fully-qualified index
     * @param  mixed  $value value of parameter
     * @return void
     */
    public function handleConfigAsIntArrayToParameter($index, $value)
    {
        if ($mergedValue = $this->hasContainerParameter($index)) {
            $value = array_merge(
                (array)$this->getContainerParameter($index),
                (array)$value
            );
        }
        else {
            $value = (array)$value;
        }

        $this->setContainerParameter($index, $value);
    }

    /**
     * Process and assign a parameter key=>value pair when it has reached a
     * singular value state (non-array).
     *
     * @param  string $index fully-qualified parameter index
     * @param  mixed  $value value of parameter
     * @return void
     */
    public function handleConfigToParameter($index, $value)
    {
        $this->setContainerParameter($index, $value);
    }

    /**
     * @param string|null $index
     */
    public function handleConfigAsEmptyToParameter($index, $value)
    {
        $this->setContainerParameter(
            $index = $this->buildParameterIndex($index),
            $value = $this->sanitizeParameterValue($value)
        );
    }

    /**
     * Sets new paramiter bag value
     *
     * @param string $index parameter key
     * @param mixed  $value parameter value
     */
    private function setContainerParameter($index, $value)
    {
        $this->getContainer()->setParameter($index, $value);
    }

    /**
     * Checks for perameter bag index existance
     *
     * @param string $index parameter key
     */
    private function hasContainerParameter($index)
    {
        return (bool)$this->getContainer()->hasParameter($index);
    }

    /**
     * Gets perameter bag value
     *
     * @param string $index parameter key
     */
    private function getContainerParameter($index)
    {
        return $this->getContainer()->getParameter($index);
    }

    /**
     * Checks to see if array is a hash or not
     *
     * @param  array $array array to check against
     * @return bool
     */
    private function isHash(array $array = [])
    {
        $keys    = array_keys($array);
        $keyKeys = array_keys($keys);
        $result  = $keyKeys !== $keys;

        return $keyKeys !== $keys;
    }

    /**
     * Sanitize parameter value by trimming extra white space from beginning
     * and end of value.
     *
     * @param  string $value parameter value to be sanitized
     * @return string
     */
    private function sanitizeParameterValue($value)
    {
        switch(gettype($value)) {
            case 'string':
                return trim($value);
            default:
                return $value;
        }

    }

    /**
     * Builds peramiter index
     *
     * @param  string $indices,... index value
     * @param string|null $indices
     * @return string
     */
    private function buildParameterIndex(...$indices)
    {
        return (string)$this->sanitizeParameterIndex(
            $this->getIndexPrefix() .
            $this->getIndexSeparator() .
            implode($this->getIndexSeparator(), $indices)
        );
    }

    /**
     * Sanitize index by only allowing alphanumeric, dashes, underscores, and
     * not consecutive periods which may have been added during paramiter index
     * build process.
     *
     * @param  string $index index string to sanitize
     * @return string
     */
    private function sanitizeParameterIndex($index)
    {
        if (preg_match('#^[a-z]#i', $index) === 0) {
            throw new RuntimeException('Dependency injection parameter indeces must begin with a letter.');
        }

        return (string)preg_replace('#\.+#', '.', preg_replace('#[^a-z0-0\._:\+-]#i', '', $index));
    }
}
