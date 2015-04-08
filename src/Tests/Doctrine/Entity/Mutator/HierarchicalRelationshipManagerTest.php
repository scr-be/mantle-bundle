<?php

/*
 * This file is part of the Scribe Mantle Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Doctrine\Entity\Node;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Utility\UnitTest\AbstractMantlePhactoryTestCase;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Doctrine\Entity\Mutator\HierarchicalRelationshipManager;

/**
 * Class NodeTest.
 */
class HierarchicalRelationshipManagerTest extends AbstractMantlePhactoryTestCase
{
    /**
     * @var Node
     */
    private $firstNode;

    /**
     * @var ArrayCollection
     */
    private $nodes;

    /**
     * @var NodeRepository 
     */
    private $repo;

    /**
     * @var HierarchicalRelationshipManager 
     */
    private $manager;

    public function setUp()
    {
        $this->repo = $this->container->get($this->config['node']['service']);
        $this->manager = new HierarchicalRelationshipManager($this->em, $this->repo);
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodes($count);
        $this->nodes = $this->nodeRows();
        $this->firstNode = $this->nodeRows()[0];
    }

    public function testCascaseDeletion()
    {
        $this->setupAndExercise(3);
        $this->firstNode->setAsRoot();
        $this->nodes[1]->setChildNodeOf($this->firstNode);
        $this->nodes[2]->setChildNodeOf($this->nodes[1]);

        $this->manager->deleteAndCascade($this->firstNode);

        $this->assertEmpty($this->nodeRows());
    }

    // error if no parent
    public function testCascadeDeleteAndReparent()
    {
        $this->setupAndExercise(4);
        $this->firstNode->setAsRoot();
        $this->nodes[1]->setChildNodeOf($this->firstNode);
        $this->nodes[2]->setChildNodeOf($this->nodes[1]);
        $this->nodes[3]->setChildNodeOf($this->nodes[2]);

        $this->manager->deleteAndReparentChildren($this->nodes[1]);

        $this->assertSame(3, sizeof($this->nodeRows()));
        $this->assertSame($this->firstNode, $this->nodes[2]->getParentNode());
        $this->assertSame($this->nodes[2], $this->nodes[3]->getParentNode());
    }

    public function testCascadeSetAsRoot()
    {
        $this->setupAndExercise(4);
        $this->firstNode->setAsRoot();
        $this->nodes[1]->setChildNodeOf($this->firstNode);
        $this->nodes[2]->setChildNodeOf($this->nodes[1]);
        $this->nodes[3]->setChildNodeOf($this->nodes[2]);
        $this->em->flush();

        $this->manager->setAsRoot($this->nodes[1]);

        $root = $this->repo->getTree('/'. $this->nodes[1]->getSlug());
        $this->assertSame($this->nodes[1]->getSlug(), $root->getSlug());
        $this->assertSame($this->nodes[2], $root->getChildNodes()[0]);

        $leaf = $root->getChildNodes()[0]->getChildNodes()[0];

        $this->assertSame($this->nodes[3], $leaf);
    }

    public function testCascadeOnSlugUpdate()
    {
        $this->setupAndExercise(4);
        $this->firstNode->setAsRoot();
        $this->nodes[1]->setChildNodeOf($this->firstNode);
        $this->nodes[2]->setChildNodeOf($this->nodes[1]);
        $this->nodes[3]->setChildNodeOf($this->nodes[2]);
        $this->em->flush();

        $newSlug = 'foo';
        $this->firstNode->setSlug($newSlug);
        $this->manager->updateAndCascade($this->firstNode);

        foreach($this->nodeRows() as $n) {
            $this->assertRegExp('/'.$newSlug.'/', $n->getMaterializedPath());
        }
    }
}
