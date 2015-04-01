<?php

/*
 * This file is part of the Scribe Mantle Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Tests\Helper\AbstractMantleEntityPhactoryUnitTestHelper;
use Scribe\MantleBundle\Entity\Node;

/**
 * Class NodeTest.
 */
class NodeTest extends AbstractMantleEntityPhactoryUnitTestHelper
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
        $this->repo = $this->container->get($this->config['node']['service']);
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodes($count);
        $this->nodes = $this->nodeRows();
        $this->firstNode = $this->nodeRows()[0];
    }

    public function testBasicPathRelationsip()
    {
        $this->setupAndExercise(2);
        $secondNode = $this->nodes[1];
        $secondNode->setChildNodeOf($this->firstNode);
        $this->assertSame($this->firstNode, $secondNode->getParentNode());
        $this->assertSame($secondNode, $this->firstNode->getChildNodes()[0]);
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
        $this->assertSame($this->firstNode, $root->getRootNode());

        // tree returns nested array
        $this->assertSame($this->firstNode, $root);
        $this->assertSame($secondNode, $root[0]);
        $this->assertSame($thirdNode, $root[0][0]);
        $this->assertSame($fourthNode, $root[0][0][0]);
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

        $this->assertSame($this->firstNode, $tree1);
        $this->assertSame($secondNode, $tree1[0]);

        $this->assertSame($thirdNode, $tree2);
        $this->assertSame($fourthNode, $tree2[0]);
    }

    public function testCanMoveBranchToBranch()
    {
        $this->setupAndExercise(4);

        $this->nodes[0]->setAsRoot();
        $this->nodes[1]->setChildNodeOf($this->nodes[0]);
        $this->nodes[2]->setChildNodeOf($this->nodes[1]);
        $this->nodes[3]->setChildNodeOf($this->nodes[2]);

        $this->em->flush();

        $this->assertSame(1, sizeof($this->nodes[0]->getChildNodes()));

        $this->nodes[2]->setChildNodeOf($this->nodes[0]);

        $this->em->flush();

        $this->assertSame(2, sizeof($this->nodes[0]->getChildNodes()));
    }

    public function testSetAsRoot()
    {
        $this->setupAndExercise(1);
        $this->firstNode->setAsRoot();
        $this->em->flush();

        $path = '/'.$this->firstNode->getSlug();

        $tree = $this->repo->getTree($path);

        $this->assertSame($this->firstNode, $tree);
    }

    public function testSetAsRootFromBranch()
    {
        $this->setupAndExercise(3);
        $branch = $this->nodes[1];
        $leaf = $this->nodes[2];

        $this->firstNode->setAsRoot();
        $branch->setChildNodeOf($this->firstNode);
        $leaf->setChildNodeOf($branch);

        $branch->setAsRoot();
        $this->em->flush();

        $path = '/'.$branch->getSlug();

        $tree = $this->repo->getTree($path);

        $this->assertSame($branch, $tree);
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
