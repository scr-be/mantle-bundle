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

use Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;

/**
 * Class NodeCreatorMocksTrait.
 */
trait NodeCreatorMocksTrait
{
    /**
     * @var Node
     */
    private $node;

    /**
     * @var NodeRepository
     */
    private $nodeRepo;

    protected function getNewNodeRendererRegistrar()
    {
        return $this->container->get('s.mantle.node_creator.renderer.registrar');
    }

    protected function mockNodeRenderEngine_Twig()
    {
        $nodeRevisionEngine = $this->getMock('Scribe\MantleBundle\Doctrine\Entity\Node\NodeRenderEngine');
        $nodeRevisionEngine
            ->method('getSlug')
            ->willReturn('twig')
        ;
        $nodeRevisionEngine
            ->method('isRenderable')
            ->willReturn(true)
        ;

        return $nodeRevisionEngine;
    }

    protected function mockNodeRenderEngine_Foo()
    {
        $nodeRevisionEngine = $this->getMock('Scribe\MantleBundle\Doctrine\Entity\Node\NodeRenderEngine');
        $nodeRevisionEngine
            ->method('getSlug')
            ->willReturn('foo')
        ;

        return $nodeRevisionEngine;
    }

    protected function mockNodeRevision_Blog($nodeRenderEngine = null)
    {
        if ($nodeRenderEngine === null) {
            $nodeRenderEngine = $this->mockNodeRenderEngine_Twig();
        }

        $nodeRevision = $this->getMock('Scribe\MantleBundle\Doctrine\Entity\Node\NodeRevision');
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
        if ($nodeRenderEngine === null) {
            $nodeRenderEngine = $this->mockNodeRenderEngine_Twig();
        }

        $nodeRevision = $this->getMock('Scribe\MantleBundle\Doctrine\Entity\Node\NodeRevision');
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
        if ($nodeRevision === null) {
            $nodeRevision = $this->mockNodeRevision_Blog();
        }

        $node = $this->getMock('Scribe\MantleBundle\Doctrine\Entity\Node\Node');
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
        $node
            ->method('getMaterializedPath')
            ->willReturn('/post_1')
        ;

        return $node;
    }

    protected function mockNodeRepository($node = null)
    {
        if ($node === null) {
            $node = $this->mockNode();
        }

        $nodeRepo = $this
            ->getMockBuilder('Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository')
            ->setMethods(['loadBySlug', 'loadByMaterializedPath'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $nodeRepo
            ->method('loadBySlug')
            ->with('post_1')
            ->willReturn($node)
        ;
        $nodeRepo
            ->method('loadByMaterializedPath')
            ->with('/post_1')
            ->willReturn($node)
        ;

        return $nodeRepo;
    }

    protected function mockNodeTwigEntities()
    {
        $this->nodeRepo = $this->mockNodeRepository();
        $this->node = $this->nodeRepo->loadBySlug('post_1');
    }

    protected function mockNodeNothingEntities()
    {
        $rev = $this->mockNodeRevision_NoRender();
        $node = $this->mockNode($rev);

        $this->nodeRepo = $this->mockNodeRepository($node);
        $this->node = $node;
    }

    protected function mockNodeMissingServiceEntities()
    {
        $engine = $this->mockNodeRenderEngine_Foo();
        $rev = $this->mockNodeRevision_Blog($engine);
        $node = $this->mockNode($rev);

        $this->nodeRepo = $this->mockNodeRepository($node);
        $this->node = $node;
    }
}

/* EOF */
