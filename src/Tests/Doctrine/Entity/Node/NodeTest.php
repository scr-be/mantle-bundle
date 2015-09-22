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
use Scribe\WonkaBundle\Utility\TestCase\PhactoryTestCase;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;

/**
 * Class NodeTest.
 */
class NodeTest extends PhactoryTestCase
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
     * @var string
     */
    private $repo;

    public function setUp()
    {
        parent::setUp();
        $this->repo = $this->container->get($this->config['node']['service']);
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodes($count);
        $this->nodes = $this->nodeRows();
        $this->firstNode = $this->nodeRows()[0];
    }

    public function testBasicPathRelationship()
    {
        $this->setupAndExercise(2);
        $secondNode = $this->nodes[1];
        $secondNode->setChildNodeOf($this->firstNode);
        static::assertSame($this->firstNode, $secondNode->getParentNode());
        static::assertSame($secondNode, $this->firstNode->getChildNodes()[0]);
    }

    public function testTree()
    {
        $this->setupAndExercise(4);
        $secondNode = $this->nodes[1];
        $thirdNode = $this->nodes[2];
        $fourthNode = $this->nodes[3];

        // have to set path for intended root
        $this->firstNode->setMaterializedPath('/slug');

        $secondNode->setChildNodeOf($this->firstNode);
        $thirdNode->setChildNodeOf($secondNode);
        $fourthNode->setChildNodeOf($thirdNode);

        $this->em->flush();
        $root = $this->repo->getTree();

        // finds root correctly
        static::assertSame($this->firstNode, $root->getRootNode());

        // tree returns nested array
        static::assertSame($this->firstNode, $root);
        static::assertSame($secondNode, $root[0]);
        static::assertSame($thirdNode, $root[0][0]);
        static::assertSame($fourthNode, $root[0][0][0]);
    }

    public function testMultipleRoots()
    {
        $this->setupAndExercise(4);
        $secondNode = $this->nodes[1];
        $thirdNode = $this->nodes[2];
        $fourthNode = $this->nodes[3];

        // have to set path for intended root
        $this->firstNode->setMaterializedPath('/foo');
        $thirdNode->setMaterializedPath('/bar');

        $secondNode->setChildNodeOf($this->firstNode);
        $fourthNode->setChildNodeOf($thirdNode);

        $this->em->flush();

        $tree1 = $this->repo->getTree('/foo');
        $tree2 = $this->repo->getTree('/bar');

        static::assertSame($this->firstNode, $tree1);
        static::assertSame($secondNode, $tree1[0]);

        static::assertSame($thirdNode, $tree2);
        static::assertSame($fourthNode, $tree2[0]);
    }

    public function testCanMoveBranchToBranch()
    {
        $this->setupAndExercise(4);

        $this->nodes[0]->setAsRoot();
        $this->nodes[1]->setChildNodeOf($this->nodes[0]);
        $this->nodes[2]->setChildNodeOf($this->nodes[1]);
        $this->nodes[3]->setChildNodeOf($this->nodes[2]);

        $this->em->flush();

        static::assertSame(1, sizeof($this->nodes[0]->getChildNodes()));

        $this->nodes[2]->setChildNodeOf($this->nodes[0]);

        $this->em->flush();

        static::assertSame(2, sizeof($this->nodes[0]->getChildNodes()));
    }

    public function testSetAsRoot()
    {
        $this->setupAndExercise(1);
        $this->firstNode->setAsRoot();
        $this->em->flush();

        $path = '/'.$this->firstNode->getSlug();

        $tree = $this->repo->getTree($path);

        static::assertSame($this->firstNode, $tree);
    }

    public function testSetAsRootFromBranch()
    {
        $this->setupAndExercise(3);
        $branch = $this->nodes[1];
        $leaf = $this->nodes[2];

        $this->firstNode->setAsRoot();
        $branch->setChildNodeOf($this->firstNode);
        $leaf->setChildNodeOf($branch);
        $this->em->flush();

        $branch->setAsRoot();
        $this->em->flush();

        $path = '/'.$branch->getSlug();

        $tree = $this->repo->getTree($path);

        static::assertSame($branch, $tree);
        /* $children = $tree->getChildNodes(); */
        /* static::assertSame($leaf, $children[0]); */
    }

    public function testIsTimestampable()
    {
        $this->setupAndExercise(2);

        $this->nodes[0]->setAsRoot();

        $this->em->flush();

        static::assertTrue(($this->nodes[0]->getCreatedOn() instanceof \Datetime));
        static::assertTrue(($this->nodes[0]->getUpdatedOn() instanceof \Datetime));

        $previousCreatedOn = clone $this->nodes[0]->getCreatedOn();
        $previousUpdatedOn = clone $this->nodes[0]->getUpdatedOn();

        static::assertTrue($this->nodes[0]->getCreatedOn() == $previousCreatedOn);
        static::assertTrue($this->nodes[0]->getUpdatedOn() <= (new \Datetime()));

        static::assertSame(0, sizeof($this->nodes[0]->getChildNodes()));

        $this->nodes[0]->setSlug('something');
        $this->nodes[1]->setChildNodeOf($this->nodes[0]);

        sleep(2);

        $this->em->flush();
        $this->em->refresh($this->nodes[0]);
        $this->em->refresh($this->nodes[1]);

        static::assertSame(1, sizeof($this->nodes[0]->getChildNodes()));

        static::assertTrue($this->nodes[0]->getCreatedOn() == $previousCreatedOn);
        static::assertTrue($this->nodes[0]->getUpdatedOn() > $previousUpdatedOn);
    }

    /* public function testCanDeleteWholeBranch() */
    /* { */
    /*     $this->setupAndExercise(3); */

    /*     $this->nodes[0]->setAsRoot(); */
    /*     $this->nodes[1]->setChildNodeOf($this->nodes[0]); */
    /*     $this->nodes[2]->setChildNodeOf($this->nodes[1]); */

    /*     $this->em->flush(); */
    /* } */
}
