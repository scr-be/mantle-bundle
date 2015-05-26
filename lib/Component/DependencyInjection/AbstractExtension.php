<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection;

use Scribe\Utility\Error\DeprecationErrorHandler;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Scribe\Component\DependencyInjection\Container\ContainerAwareInterface;
use Scribe\Component\DependencyInjection\Container\ContainerAwareTrait;
use Scribe\Component\DependencyInjection\Loader\XmlFileLoader;
use Scribe\Component\DependencyInjection\Loader\YamlFileLoader;
use Scribe\Utility\Arrays;
use Scribe\Utility\Filter\StringFilter;
use Scribe\Exception\RuntimeException;

/**
 * Class AbstractExtension.
 */
abstract class AbstractExtension extends Extension implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Service files to load.
     *
     * @var string[]
     */
    private $serviceFiles = [
        'services.yml'
    ];

    /**
     * Index prefix property.
     *
     * @var string
     */
    private $indexPrefix = 'scribe';

    /**
     * Index parts separator.
     *
     * @var string
     */
    private $indexSeparator = '.';

    /**
     * Set the service files to load.
     *
     * @param array $files
     *
     * @return $this
     */
    protected function setServiceFiles(array $files = [])
    {
        $this->serviceFiles = $files;

        return $this;
    }

    /**
     * Get the service files to load.
     *
     * @return string[]
     */
    protected function getServiceFiles()
    {
        return $this->serviceFiles;
    }

    /**
     * Setter for index prefix.
     *
     * @param string $prefix prefix for parameter keys (indexes)
     *
     * @return $this
     */
    protected function setIndexPrefix($prefix)
    {
        StringFilter::isLongerThan($prefix, 0);
        $this->indexPrefix = (string) $prefix;

        return $this;
    }

    /**
     * Getter for index prefix.
     *
     * @return string
     */
    protected function getIndexPrefix()
    {
        return (string) $this->indexPrefix;
    }

    /**
     * Setter for index parts separator.
     *
     * @param string $separator parameter index separator
     *
     * @return $this
     */
    protected function setIndexSeparator($separator)
    {
        StringFilter::isLongerThan($separator, 0);
        $this->indexSeparator = (string) $separator;

        return $this;
    }

    /**
     * Getter for index parts separator.
     *
     * @return string
     */
    protected function getIndexSeparator()
    {
        return (string) $this->indexSeparator;
    }

    /**
     * Loads the configuration (builds the container).
     *
     * @param array            $configs   collection of configs to load
     * @param ContainerBuilder $container symfony config container
     */
    abstract public function load(array $configs, ContainerBuilder $container);

    /**
     * Helper method to be called from load method ({@see load}) that automates
     * the tedious task of parsing the config tree to container parameter as well
     * as loading any required service definition files.
     *
     * @param array                  $configs
     * @param ContainerBuilder       $container
     * @param ConfigurationInterface $configuration
     * @param string|null            $prefix
     */
    final protected function autoLoad(array $configs, ContainerBuilder $container, ConfigurationInterface $configuration, $prefix = null)
    {
        $this->setContainer($container);

        $this
            ->autoLoadConfiguration($configs, $configuration, $prefix)
            ->autoLoadServices($container)
        ;
    }

    /**
     * Process the configuration and then load the resulting multi-dimensional
     * {@see $configs} array to useful container parameter indexes with their
     * respective values set.
     *
     * @param array                  $configs
     * @param ConfigurationInterface $configuration
     * @param string|null            $prefix
     *
     * @return $this
     */
    final protected function autoLoadConfiguration(array $configs, ConfigurationInterface $configuration, $prefix = null)
    {
        $config = $this->processConfiguration($configuration, $configs);

        if (null !== $prefix) {
            $this->setIndexPrefix($prefix);
        }

        $this->processConfigsToParameters($config);

        return $this;
    }

    /**
     * Load all the services by iterating over the {@see $this->serviceFiles}
     * defined at runtime; either Yaml or XML based.
     *
     * @param ContainerBuilder $container
     *
     * @return $this
     */
    final protected function autoLoadServices(ContainerBuilder $container)
    {
        $resolvedDirectory = $this->resolveBundleDirectory($container);

        foreach ($this->getServiceFiles() as $file) {
            $loader = $this->resolveServiceFileLoader($file);

            $loader->setup(
                $container,
                new FileLocator($resolvedDirectory.'/../Resources/config')
            );

            $loader->load($file);
        }

        return $this;
    }

    /**
     * Normally, the {@see FileLocator} would be given the constant __DIR__ when
     * such configuration is defined within each explicit bundle. As {@see autoLoadService}
     * moves such functionality into this abstraction class, __DIR__ would return
     * the wrong result. Instead, we utilize the first FileResource attached to
     * the container to determine the path to the correct /Scribe[A-Z][a-z]*Bundle\.php/
     * file, allowing us to load the correct services and/or additional config files.
     *
     * @param ContainerBuilder $container
     *
     * @return string
     */
    protected function resolveBundleDirectory(ContainerBuilder $container)
    {
        $resources = $container->getResources();

        if (true === (count($resources) > 0)) {
            $bundleFilePath = (string) current($resources);

            return (string) dirname($bundleFilePath);
        }

        return (string) __DIR__;
    }

    /**
     * Based on the file extension, resolve the correct FileLoader object to
     * instantiate and return for the passed file argument.
     *
     * @param string $file
     *
     * @return XmlFileLoader|YamlFileLoader
     */
    protected function resolveServiceFileLoader($file)
    {
        switch (pathinfo($file, PATHINFO_EXTENSION)) {
            case 'xml':

                return new XmlFileLoader();

            case 'yml':
            case 'yaml':

                return new YamlFileLoader();

            default:

                throw new RuntimeException(
                    sprintf('No available service file loader for %s file with %s extension type.', $file, $extension)
                );
        }
    }

    /**
     * Process config array to container parameter key=>values.
     *
     * @param array  $config Configs multi-dimensional array
     * @param string $outer  Built parameter index,
     *
     * @return $this
     */
    protected function processConfigsToParameters(array $config = [], $outer = null)
    {
        if (true === (count($config) === 0)) {
            $this->handleConfigsToParameterWhenEmpty($outer, $config);

            return $this;
        }

        foreach ($config as $i => $v) {
            $built = $this->buildConfigParameterIndex($outer, $i);

            if (true === is_array($v)) {
                $this->handleConfigsToParameterWhenArray($built, $outer, $i, $v);
            } else {
                $this->handleConfigsToParameterWhenNotArray($built, $v);
            }
        }

        return $this;
    }

    /**
     * handleConfigsToParametersWhenArray.
     *
     * @param string $built Final index (with prefix)
     * @param string $outer Final index
     * @param string $i     Current index
     * @param mixed  $v     Parameter value
     */
    protected function handleConfigsToParameterWhenArray($built, $outer, $i, $v)
    {
        if (true === (substr($i, 0, 4) === '!a::')) {
            DeprecationErrorHandler::trigger(
                __METHOD__, __LINE__,
                'The configuration builder node prefix "!a::" has been replaced in favor of the postfix "_list".',
                '2015-05-25 04:40:00 -0400', '2.0.0'
            );
            $this->handleConfigsToParameterWhenArrayHash($built, $i, $v, 'a::');
        } elseif (true === (substr($i, -5, 5) === '_list')) {
            $this->handleConfigsToParameterWhenArrayHash($built, $i, $v, '_list');
        } elseif (false === Arrays::isHash($v, false)) {
            $this->handleConfigsToParameterWhenArrayInt($built, $v);
        } else {
            $this->processConfigsToParameters($v, $outer.$this->getIndexSeparator().$i);
        }
    }

    /**
     * Process and assign a parameter config value when it is a yaml list, which
     * is translated to a non-hash (integer-key-based) array and assign the
     * parameter value, merging any previous entries in the array.
     *
     * @param string $built Final index (with prefix)
     * @param mixed  $v     Parameter value
     */
    public function handleConfigsToParameterWhenArrayInt($built, $v)
    {
        if (true === $this->hasContainerParameter($built)) {
            $v = array_merge(
                (array) $this->getContainerParameter($built),
                (array) $v
            );
        }

        $this->setContainerParameter($built, (array) $v);
    }

    /**
     * Process and assign a parameter config value when it is a yaml list that
     * is specifically configured not to handle using the default means of treating
     * it as an integer list, as {@see handleConfigsToParameterSetAsIntArray} would.
     *
     * @param string $built  Final index (with prefix)
     * @param string $i      Current index
     * @param mixed  $v      Parameter value
     * @param string $search Value to search and replace with nothing from key
     */
    public function handleConfigsToParameterWhenArrayHash($built, $i, $v, $search = '')
    {
        $this->setContainerParameter(
            str_replace($search, '', $built),
            $v
        );
    }

    /**
     * Process and assign a parameter key=>value pair when it has reached a
     * singular value state (non-array).
     *
     * @param string $built Final index (with prefix)
     * @param mixed  $v     Parameter value
     */
    public function handleConfigsToParameterWhenNotArray($built, $v)
    {
        $this->setContainerParameter($built, $v);
    }

    /**
     * @param string|array $indicies Index/indicies
     * @param mixed        $v        Parameter value
     */
    public function handleConfigsToParameterWhenEmpty($indicies, $v)
    {
        $this->setContainerParameter(
            $this->buildConfigParameterIndex($indicies),
            $this->sanitizeConfigParameterValue($v)
        );
    }

    /**
     * Assigns a parameter and corresponding value to the container.
     *
     * @param string $built Final index (with prefix)
     * @param mixed  $v     Parameter value
     */
    private function setContainerParameter($built, $v)
    {
        $this
            ->getContainer()
            ->setParameter($built, $v)
        ;
    }

    /**
     * Builds a final parameter index via the configured prefix and supplied
     * indicies concatenated using the configured separator.
     *
     * @param ...string $indices The index parts
     *
     * @return string
     */
    private function buildConfigParameterIndex(...$indices)
    {
        return (string) $this->sanitizeConfigParameterIndex(
            $this->getIndexPrefix().
            $this->getIndexSeparator().
            implode($this->getIndexSeparator(), $indices)
        );
    }

    /**
     * Sanitize index by only allowing alphanumeric, dashes, underscores, and
     * not consecutive periods which may have been added during the index
     * build process. DI parameters must also begin with a letter; exeption throw
     * otherwise.
     *
     * @param string $built Final index (with prefix)
     *
     * @return string
     *
     * @throws RuntimeException
     */
    private function sanitizeConfigParameterIndex($built)
    {
        if (preg_match('#^[a-z]#i', $built) === 0) {
            throw new RuntimeException(
                'Dependency injection parameter indexes must begin with a letter.'
            );
        }

        return (string) preg_replace(
            '#\.+#', '.',
            preg_replace('#[^a-z0-0\._:\+-]#i', '', $built)
        );
    }

    /**
     * Sanitize parameter value; if string whitespace is trimmed from both the
     * beginning and end; otherwise, value is returned as-is.
     *
     * @param mixed $v Parameter value
     *
     * @return mixed
     */
    private function sanitizeConfigParameterValue($v)
    {
        switch (gettype($v)) {
            case 'string':

                return trim($v);

            default:

                return $v;
        }
    }
}

/* EOF */
