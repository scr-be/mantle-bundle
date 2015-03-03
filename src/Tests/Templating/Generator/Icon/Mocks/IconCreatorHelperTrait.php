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
            return new IconCreatorCached($this->iconFamilyRepo, $this->engine);
        }
        else {
            return new IconCreator($this->iconFamilyRepo, $this->engine);
        }
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
}

/* EOF */
