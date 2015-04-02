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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Templating\Generator\Node\NodeCreator;
use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Node\Mocks\NodeCreatorHelperTrait;
use Scribe\Tests\Helper\AbstractMantleKernelUnitTestHelper;

/**
 * Class NodeCreatorTest.
 */
class NodeCreatorTest extends AbstractMantleKernelUnitTestHelper
{
    use NodeCreatorMocksTrait,
        NodeCreatorHelperTrait;

    const FULLY_QUALIFIED_CLASS_NAME_ICON_FAMILY_REPO = 'Scribe\MantleBundle\EntityRepository\NodeFamilyRepository';

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

    public function testRenderFromBadSlugThrowsException()
    {
        $this->mockNodeTwigEntities();
        $creator = $this->getNewNodeCreator(); 

        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Node\NodeException',
            'Node with slug foo could not be found.',
            '101'
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
}
