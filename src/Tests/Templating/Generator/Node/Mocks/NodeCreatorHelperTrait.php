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

use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChain;
use Scribe\CacheBundle\Cache\Handler\Type\HandlerTypeFilesystem;
use Scribe\CacheBundle\KeyGenerator\KeyGenerator;
use Scribe\CacheBundle\KeyGenerator\KeyGeneratorInterface;
use Scribe\MantleBundle\Templating\Generator\Node\NodeCreator;
use Scribe\MantleBundle\Templating\Generator\Node\ServiceFinder;

/**
 * Class NodeCreatorHelperTrait.
 */
trait NodeCreatorHelperTrait
{
    protected function getNewNodeCreator()
    {
        $serviceFinder = new ServiceFinder($this->container);
        $nodeGenerator = new NodeCreator($serviceFinder, $this->nodeRepo);

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
}
