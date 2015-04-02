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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Entity\NodeRevision;
use Scribe\MantleBundle\Entity\Node;

/**
 * Class NodeCreatorMocksTrait.
 */
trait NodeCreatorMocksTrait
{
    private $node;

    private $nodeRepo;

    protected function mockNodeRenderEngine_Twig()
    {
        $nodeRevisionEngine = $this->getMock('Scribe\MantleBundle\Entity\NodeRenderEngine');
        $nodeRevisionEngine
            ->method('getSlug')
            ->willReturn('twig')
        ;
        $nodeRevisionEngine
            ->method('getService')
            ->willReturn('s.mantle.node.twig.render')
        ;
        $nodeRevisionEngine
            ->method('isRenderable')
            ->willReturn(true)
        ;

        
        return $nodeRevisionEngine;
    }

    protected function mockNodeRevision_Blog($nodeRenderEngine = null)
    {
        if ($nodeRenderEngine === null) { $nodeRenderEngine = $this->mockNodeRenderEngine_Twig(); }

        $nodeRevision = $this->getMock('Scribe\MantleBundle\Entity\NodeRevision');
        $nodeRevision
            ->method('getSlug')
            ->willReturn('blog_post')
        ;
        $nodeRevision
            ->method('getContent')
            ->willReturn('<div id="foo">{{ title }}</div>')
        ;
        $nodeRevision
            ->method('getRenderEngine')
            ->willReturn($nodeRenderEngine)
        ;
        $nodeRevision
            ->method('hasRenderEngine')
            ->willReturn(true)
        ;

        return $nodeRevision;
    }

    protected function mockNodeRevision_NoRender($nodeRenderEngine = null)
    {
        if ($nodeRenderEngine === null) { $nodeRenderEngine = $this->mockNodeRenderEngine_Twig(); }

        $nodeRevision = $this->getMock('Scribe\MantleBundle\Entity\NodeRevision');
        $nodeRevision
            ->method('getSlug')
            ->willReturn('blog_post')
        ;
        $nodeRevision
            ->method('getContent')
            ->willReturn('<div id="foo">{{ title }}</div>')
        ;
        $nodeRevision
            ->method('getRenderEngine')
            ->willReturn($nodeRenderEngine)
        ;
        $nodeRevision
            ->method('hasRenderEngine')
            ->willReturn(false)
        ;

        return $nodeRevision;
    }

    protected function mockNode($nodeRevision = null)
    {
        if ($nodeRevision === null) { $nodeRevision = $this->mockNodeRevision_Blog(); }

        $node = $this->getMock('Scribe\MantleBundle\Entity\Node');
        $node
            ->method('getLatestRevision')
            ->willReturn($nodeRevision)
        ;
        $node
            ->method('getTitle')
            ->willReturn('Post 1')
        ;
        $node
            ->method('getSlug')
            ->willReturn('post_1')
        ;

        return $node;
    }

    protected function mockNodeRepository($node = null)
    {
        if ($node === null) { $node = $this->mockNode(); }

        $nodeRepo = $this
            ->getMockBuilder('Scribe\MantleBundle\EntityRepository\NodeRepository')
            ->setMethods(['findOneBySlug'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $nodeRepo
            ->method('findOneBySlug')
            ->with('post_1')
            ->willReturn($node)
        ;

        return $nodeRepo;
    }

    protected function mockNodeTwigEntities()
    {
        $this->nodeRepo = $this->mockNodeRepository();
        $this->node = $this->nodeRepo->findOneBySlug('post_1');
    }

    protected function mockNodeNothingEntities()
    {
        $rev = $this->mockNodeRevision_NoRender();
        $node = $this->mockNode($rev);

        $this->nodeRepo = $this->mockNodeRepository($node);
        $this->node = $node;
    }
}

/* EOF */
