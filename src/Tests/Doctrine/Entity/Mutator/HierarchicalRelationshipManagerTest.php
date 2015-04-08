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
}
