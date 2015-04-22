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

    public function setupAndNestXTimes($x = 3)
    {
        $this->setupAndExercise($x);
        $this->firstNode->setAsRoot();
        for ($k = 0; $k < ($x - 1); $k++) {
            $this->nodes[$k + 1]->setChildNodeOf($this->nodes[$k]);
        }
    }

    //## deleteAndCascade tests

    public function testCascadeDeletion()
    {
        $this->setupAndNestXTimes();
        $this->manager->deleteAndCascade($this->firstNode);

        $this->assertEmpty($this->nodeRows());
    }

    public function testCascadeDeleteBySlug()
    {
        $this->setupAndNestXTimes();
        $this->manager->deleteAndCascadeBySlug($this->firstNode->getSlug());

        $this->assertEmpty($this->nodeRows());
    }

    public function testCascadeDeleteByMaterializedPath()
    {
        $this->setupAndNestXTimes();
        $this->em->flush();
        $this->manager->deleteAndCascadeByMaterializedPath($this->firstNode->getMaterializedPath());

        $this->assertEmpty($this->nodeRows());
    }

    public function testCascaseDeletionByBadSlugErrors()
    {
        $this->setupAndNestXTimes();

        $this->setExpectedException(
            'Scribe\MantleBundle\Doctrine\Entity\Mutator\HierarchicalRelationshipException',
            'Node with slug foo could not be found.',
            '5040'
        );
        $this->manager->deleteAndCascadeBySlug('foo');
    }

    public function testCascadeDeletionFromService()
    {
        $this->setupAndNestXTimes();
        $newManager = $this->container->get('s.mantle.hier_rel_manager');
        $newManager->deleteAndCascade($this->firstNode);

        $this->assertEmpty($this->nodeRows());
    }

    //## deleteAndReparentChildren tests

    public function assertDeletedAndReparentedCorrectly()
    {
        $this->assertSame(3, sizeof($this->nodeRows()));
        $this->assertSame($this->firstNode, $this->nodes[2]->getParentNode());
        $this->assertSame($this->nodes[2], $this->nodes[3]->getParentNode());
    }

    public function testCascadeDeleteAndReparent()
    {
        $this->setupAndNestXTimes(4);
        $this->manager->deleteAndReparentChildren($this->nodes[1]);

        $this->assertDeletedAndReparentedCorrectly();
    }

    public function testCascadeDeleteAndReparentBySlug()
    {
        $this->setupAndNestXTimes(4);
        $this->manager->deleteAndReparentChildrenBySlug($this->nodes[1]->getSlug());

        $this->assertDeletedAndReparentedCorrectly();
    }

    public function testCascadeDeleteAndReparentByMaterializedPath()
    {
        $this->setupAndNestXTimes(4);
        $this->em->flush();
        $this->manager->deleteAndReparentChildrenByMaterializedPath($this->nodes[1]->getMaterializedPath());

        $this->assertDeletedAndReparentedCorrectly();
    }

    //## setAsRoot tests

    public function assertSetNodeAsRootCorrectly()
    {
        $root = $this->repo->getTree('/'.$this->nodes[1]->getSlug());
        $this->assertSame($this->nodes[1]->getSlug(), $root->getSlug());
        $this->assertSame($this->nodes[2], $root->getChildNodes()[0]);

        $leaf = $root->getChildNodes()[0]->getChildNodes()[0];

        $this->assertSame($this->nodes[3], $leaf);
    }

    public function testCascadeSetAsRoot()
    {
        $this->setupAndNestXTimes(4);
        $this->em->flush();
        $this->manager->setAsRoot($this->nodes[1]);

        $this->assertSetNodeAsRootCorrectly();
    }

    public function testCascadeSetAsRootBySlug()
    {
        $this->setupAndNestXTimes(4);
        $this->em->flush();
        $this->manager->setAsRootBySlug($this->nodes[1]->getSlug());

        $this->assertSetNodeAsRootCorrectly();
    }

    public function testCascadeSetAsRootByMaterializedPath()
    {
        $this->setupAndNestXTimes(4);
        $this->em->flush();
        $this->manager->setAsRootByMaterializedPath($this->nodes[1]->getMaterializedPath());

        $this->assertSetNodeAsRootCorrectly();
    }

    //## updateAndCascade tests

    public function testCascadeOnSlugUpdate()
    {
        $this->setupAndNestXTimes(4);
        $this->em->flush();

        $newSlug = 'foo';
        $this->firstNode->setSlug($newSlug);
        $this->manager->updateAndCascade($this->firstNode);

        foreach ($this->nodeRows() as $n) {
            $this->assertRegExp('/'.$newSlug.'/', $n->getMaterializedPath());
        }
    }

    public function testCascadeOnSlugUpdateByMaterializedPath()
    {
        $this->setupAndNestXTimes(4);
        $this->em->flush();

        $newSlug = 'foo';
        $this->firstNode->setSlug($newSlug);
        $this->manager->updateAndCascadeByMaterializedPath($this->firstNode->getMaterializedPath());

        foreach ($this->nodeRows() as $n) {
            $this->assertRegExp('/'.$newSlug.'/', $n->getMaterializedPath());
        }
    }
}
