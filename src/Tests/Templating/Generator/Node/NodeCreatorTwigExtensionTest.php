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
use Scribe\MantleBundle\Templating\Generator\Node\Extension\NodeCreatorExtension;
use Scribe\WonkaBundle\Utility\TestCase\KernelTestCase;
use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorHelperTrait;

/**
 * Class NodeCreatorExtensionTest.
 */
class NodeCreatorTwigExtensionTest extends KernelTestCase
{
    use NodeCreatorMocksTrait;
    use NodeCreatorHelperTrait;

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
        $this->ext = new NodeCreatorExtension($this->getNewNodeCreator());
        $this->extCached = new NodeCreatorExtension($this->getNewNodeCreator(true));
    }

    public function testCanRender()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual = $this->ext->getNode($this->node);

        static::assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testCanRenderFromSlug()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual = $this->ext->getNodeFromSlug($this->node->getSlug());

        static::assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testCanRenderFromMaterializedPath()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual = $this->ext->getNodeFromMaterializedPath($this->node->getMaterializedPath());

        static::assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testCanRenderCached()
    {
        $expected = '<div id="foo">Post 1</div>';

        $actual1 = $this->extCached->getNode($this->node);
        $actual2 = $this->extCached->getNode($this->node);

        static::assertXmlStringEqualsXmlString($expected, $actual1);
        static::assertXmlStringEqualsXmlString($expected, $actual2);
    }

    public function tearDown()
    {
        $this->clearFilesystemCache();

        parent::tearDown();
    }
}
