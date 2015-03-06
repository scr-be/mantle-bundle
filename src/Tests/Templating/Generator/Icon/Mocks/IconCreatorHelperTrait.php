<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks;

use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChain;
use Scribe\CacheBundle\Cache\Handler\Type\HandlerTypeFilesystem;
use Scribe\CacheBundle\KeyGenerator\KeyGenerator;
use Scribe\CacheBundle\KeyGenerator\KeyGeneratorInterface;
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreator;
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorCached;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\IconCreatorTest;

/**
 * Class IconCreatorHelperTrait
 *
 * @package Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks
 */
trait IconCreatorHelperTrait
{
    protected function getNewIconCreator($cached = false)
    {
        if($cached) {
            $iconGenerator = new IconCreatorCached($this->iconFamilyRepo, $this->engine);
            $iconGenerator->setCacheHandlerChain($this->cacheChain);
        }
        else {
            $iconGenerator = new IconCreator($this->iconFamilyRepo, $this->engine);
        }

        return $iconGenerator;
    }

    protected function getNewIconCreatorNoEngine($cached = false)
    {
        if($cached) {
            $iconGenerator = new IconCreatorCached($this->iconFamilyRepo);
            $iconGenerator->setCacheHandlerChain($this->cacheChain);
        }
        else {
            $iconGenerator = new IconCreator($this->iconFamilyRepo);
        }

        return $iconGenerator;
    }

    protected function getNewKeyGenerator()
    {
        $keyGenerator = new KeyGenerator;
        $keyGenerator->setKeyPrefix('scribe_mantle');

        return $keyGenerator;
    }

    protected function getNewCacheHandlerTypeFilesystem(KeyGeneratorInterface $keyGenerator, $tempDirectory = null)
    {
        if (null === $tempDirectory) {
            $tempDirectory = sys_get_temp_dir();
        }

        $filesystemCacheType = new HandlerTypeFilesystem($keyGenerator, 1800, 20);
        $filesystemCacheType->proposeCacheDirectory($tempDirectory);

        return $filesystemCacheType;
    }

    protected function getNewCacheHandlerChain($disabled = false)
    {
        return new HandlerChain($disabled);
    }

    protected function setHandlerTypesToCacheChain($chain, ...$types)
    {
        foreach ($types as $priority => $type) {
            $chain->addHandler($type, $priority);
        }
    }

    protected function getNewHandlerChainWithAllHandlerTypes($disabled = false)
    {
        $this->keyGenerator        = $this->getNewKeyGenerator();
        $this->cacheTypeFilesystem = $this->getNewCacheHandlerTypeFilesystem($this->keyGenerator);
        $this->cacheChain          = $this->getNewCacheHandlerChain($disabled);

        $this->setHandlerTypesToCacheChain(
            $this->cacheChain,
            $this->cacheTypeFilesystem
        );

        return $this->cacheChain;
    }

    /**
     * Overwrites PHPUnit_Framework_Assert method to clean whitespace
     * between elements before comparison.
     * Asserts that two XML documents are equal.
     *
     * @param string $expectedXml
     * @param string $actualXml
     * @param string $message
     */
    public static function assertXmlStringEqualsXmlString($expectedXml, $actualXml, $message = '')
    {
        $expectedXml = preg_replace ('/>[\s\n]*</', '><', $expectedXml);
        $actualXml = preg_replace ('/>[\s\n]*</', '><', $actualXml);

        parent::assertXmlStringEqualsXmlString($expectedXml, $actualXml, $message);
    }

    /**
     * Overwrites PHPUnit_Framework_Assert method to clean whitespace 
     * between elements before comparison.
     * Asserts that two XML documents are not equal.
     *
     * @param string $expectedXml
     * @param string $actualXml
     * @param string $message
     */
    public static function assertXmlStringNotEqualsXmlString($expectedXml, $actualXml, $message = '')
    {
        $expectedXml = preg_replace ('/>[\s\n]*</', '><', $expectedXml);
        $actualXml = preg_replace ('/>[\s\n]*</', '><', $actualXml);

        parent::assertXmlStringNotEqualsXmlString($expectedXml, $actualXml, $message);
    }

    protected function getReflectionOfIconCreatorForMethod($method)
    {
        $obj = $this->getNewIconCreator();
        $refFormat = new \ReflectionClass(IconCreatorTest::FULLY_QUALIFIED_CLASS_NAME_SELF);

        $method = $refFormat->getMethod($method);
        $method->setAccessible(true);

        return [
            $obj,
            $method
        ];
    }

    protected function getReflectionOfIconCreatorForMethods(...$methods)
    {
        $obj = $this->getNewIconCreator();
        $refFormat = new \ReflectionClass(IconCreatorTest::FULLY_QUALIFIED_CLASS_NAME_SELF);

        $construct = $refFormat->getMethod('__construct');
        $construct->setAccessible(true);
        $construct->invokeArgs($obj, [$this->iconFamilyRepo, $this->engine]);

        $returnedMethods = [];
        foreach ($methods as $i => $m) {
            $returnedMethods[$i] = $refFormat->getMethod($m);
            $returnedMethods[$i]->setAccessible(true);
        }

        return array_merge([ $obj ], $returnedMethods);
    }

    protected function clearFilesystemCache()
    {
        $tempDirBase = sys_get_temp_dir();
        $tempDir     = $tempDirBase . DIRECTORY_SEPARATOR . 'scribe_cache';

        if (false === is_dir($tempDir)) {

            return;
        }
        $kg = new KeyGenerator;
        $files = glob($tempDir . '/scribe*');
        foreach ($files as $f) {
            if (substr($f, 0, 1) == '.') {
                continue;
            }
            unlink($f);
        }

        rmdir($tempDir);
    }

    protected function clearKernelCache()
    {
        if (!$this->container instanceof ContainerInterface) {
            return;
        }

        $cacheDir = $this->container->getParameter('kernel.cache_dir');

        if (true === is_dir($cacheDir)) {
            $this->removeDirectoryRecursive($cacheDir);
        }
    }

    protected function removeDirectoryRecursive($path)
    {
        $files = glob($path . '/*');

        if (false === is_array($files)) {
            return;
        }

        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectoryRecursive($file) : unlink($file);
        }

        rmdir($path);
    }
}

/* EOF */
