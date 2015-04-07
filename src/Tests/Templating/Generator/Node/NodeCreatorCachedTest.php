<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Templating\Generator\Node;

use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorHelperTrait;
use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;

/**
 * Class NodeCreatorTest.
 */
class NodeCreatorCachedTest extends AbstractMantleKernelTestCase
{
    use NodeCreatorMocksTrait,
        NodeCreatorHelperTrait;

    public function setUp()
    {
        $this->getNewHandlerChainWithAllHandlerTypes();

        parent::setUp();
    }

    public function testCachesBasicTwigRender()
    {
        $this->mockNodeTwigEntities();
        $expected = '<div id="foo">Post 1</div>';

        $creator = $this->getNewNodeCreator(true);
        $actual = $creator->render($this->node);

        $this->assertTrue($creator->getCacheHandlerChain()->has());
        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function tearDown()
    {
        $this->clearFilesystemCache();

        parent::tearDown();
    }
}
