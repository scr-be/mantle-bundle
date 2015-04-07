<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks;

use Scribe\Component\DependencyInjection\Container\ServiceFinder;
use Scribe\MantleBundle\Templating\Generator\Node\NodeCreator;
use Scribe\MantleBundle\Templating\Generator\Node\NodeCreatorCached;
use Scribe\CacheBundle\KeyGenerator\KeyGenerator;
use Scribe\CacheBundle\Cache\Handler\Type\HandlerTypeFilesystem;
use Scribe\CacheBundle\KeyGenerator\KeyGeneratorInterface;
use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChain;

/**
 * Class NodeCreatorHelperTrait.
 */
trait NodeCreatorHelperTrait
{
    protected function getNewNodeCreator($cached = false)
    {
        $serviceFinder = new ServiceFinder($this->container);
        if (true === (bool) $cached) {
            $nodeGenerator = new NodeCreatorCached($this->nodeRepo, $this->getNewNodeRendererRegistrar());
            $nodeGenerator->setCacheHandlerChain($this->cacheChain);
        } else {
            $nodeGenerator = new NodeCreator($this->nodeRepo, $this->getNewNodeRendererRegistrar());
        }

        return $nodeGenerator;
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
        $expectedXml = preg_replace('/>[\s\n]*</', '><', $expectedXml);
        $actualXml = preg_replace('/>[\s\n]*</', '><', $actualXml);

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
        $expectedXml = preg_replace('/>[\s\n]*</', '><', $expectedXml);
        $actualXml = preg_replace('/>[\s\n]*</', '><', $actualXml);

        parent::assertXmlStringNotEqualsXmlString($expectedXml, $actualXml, $message);
    }

    protected function getNewKeyGenerator()
    {
        $keyGenerator = new KeyGenerator();
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

    protected function clearFilesystemCache()
    {
        $tempDirBase = sys_get_temp_dir();
        $tempDir     = $tempDirBase.DIRECTORY_SEPARATOR.'scribe_cache';

        if (false === is_dir($tempDir)) {
            return;
        }
        $kg = new KeyGenerator();
        $files = glob($tempDir.'/scribe*');
        foreach ($files as $f) {
            if (substr($f, 0, 1) == '.') {
                continue;
            }
            unlink($f);
        }

        rmdir($tempDir);
    }
}
