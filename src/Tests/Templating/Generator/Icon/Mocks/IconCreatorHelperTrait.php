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
    protected function assertSameHtml($resulted, $expected)
    {
        $this->assertSame(
            $this->sanitizeHtml($resulted),
            $this->sanitizeHtml($expected)
        );
    }

    protected function getNewIconCreator()
    {
        return new IconCreator($this->iconFamilyRepo, $this->engine);
    }

    protected function sanitizeHtml($html)
    {
        $config = [
            'clean'          => true,
            'output-xhtml'   => true,
            'show-body-only' => true,
            'wrap'           => 0,
        ];

        $tidy = new \Tidy;
        $tidy->parseString($html, $config, 'utf8');
        $tidy->cleanRepair();

        return (string) $tidy;
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
