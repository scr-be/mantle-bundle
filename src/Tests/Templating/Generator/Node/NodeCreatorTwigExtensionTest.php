<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Templating\Extension;

use Twig_Environment;
use Scribe\MantleBundle\Templating\Generator\Node\NodeCreatorTwigExtension;
use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;
use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorHelperTrait;

/**
 * Class NodeCreatorExtensionTest.
 */
class NodeCreatorTwigExtensionTest extends AbstractMantleKernelTestCase
{
    use NodeCreatorMocksTrait,
        NodeCreatorHelperTrait;

    /**
     * @var NodeCreatorExtension
     */
    protected $ext;

    /**
     * @var NodeCreatorExtension
     */
    protected $extCached;

    /**
     * @var Twig_Environment
     */
    protected $twig;

    public function setUp()
    {
        parent::setUp();

        $this->twig = $this
            ->container
            ->get('twig')
        ;

        $this->mockNodeTwigEntities();
        $this->getNewHandlerChainWithAllHandlerTypes();
        $this->ext       = new NodeCreatorTwigExtension($this->getNewNodeCreator());
        $this->extCached = new NodeCreatorTwigExtension($this->getNewNodeCreator(true));
    }

    public function testCanRender()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual = $this->ext->getNode($this->node);

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testCanRenderFromSlug()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual = $this->ext->getNodeFromSlug($this->node->getSlug());

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testCanRenderFromMaterializedPath()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual = $this->ext->getNodeFromMaterializedPath($this->node->getMaterializedPath());

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testCanRenderCached()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual1 = $this->extCached->getNode($this->node);
        $actual2 = $this->extCached->getNode($this->node);

        $this->assertXmlStringEqualsXmlString($expected, $actual1);
        $this->assertXmlStringEqualsXmlString($expected, $actual2);
    }

    public function tearDown()
    {
        $this->clearFilesystemCache();

        parent::tearDown();
    }
}
