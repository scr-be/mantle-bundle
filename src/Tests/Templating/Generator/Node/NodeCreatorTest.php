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
class NodeCreatorTest extends AbstractMantleKernelTestCase
{
    use NodeCreatorMocksTrait,
        NodeCreatorHelperTrait;

    const FULLY_QUALIFIED_CLASS_NAME_ICON_FAMILY_REPO = 'Scribe\MantleBundle\Doctrine\Repository\Node\NodeFamilyRepository';

    const FULLY_QUALIFIED_CLASS_NAME_SELF = 'Scribe\MantleBundle\Templating\Generator\Node\NodeCreator';

    public function setUp()
    {
        parent::setUp();
    }

    public function testBasicTwigRender()
    {
        $this->mockNodeTwigEntities();
        $expected = '<div id="foo">Post 1</div>';

        $creator = $this->getNewNodeCreator();
        $actual = $creator->render($this->node);

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testRenderFromSlug()
    {
        $this->mockNodeTwigEntities();
        $expected = '<div id="foo">Post 1</div>';

        $creator = $this->getNewNodeCreator();
        $actual = $creator->renderFromSlug($this->node->getSlug());

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testRenderFromMaterializedPath()
    {
        $this->mockNodeTwigEntities();
        $expected = '<div id="foo">Post 1</div>';

        $creator = $this->getNewNodeCreator();
        $actual = $creator->renderFromMaterializedPath($this->node->getMaterializedPath());

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testRenderFromBadSlugThrowsException()
    {
        $this->mockNodeTwigEntities();
        $creator = $this->getNewNodeCreator();

        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Node\Exception\NodeORMException',
            'Node with slug foo could not be found.',
            '5040'
        );
        $actual = $creator->renderFromSlug('foo');
    }

    public function testNoRender()
    {
        $this->mockNodeNothingEntities();
        $expected = $this
            ->node
            ->getLatestRevision()
            ->getContent()
        ;

        $creator = $this->getNewNodeCreator();
        $actual = $creator->render($this->node);

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testNoService()
    {
        $this->mockNodeMissingServiceEntities();
        $creator = $this->getNewNodeCreator();

        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Node\Exception\NodeException',
            'Could not find a renderer for the requested type template type of "foo".',
            '201'
        );
        $actual = $creator->render($this->node);
    }
}
