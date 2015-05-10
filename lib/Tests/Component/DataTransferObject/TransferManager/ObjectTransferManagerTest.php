<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Component\DataTransferObject\TransferManager;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Component\DataTransferObject\MappingDefinition\ObjectMappingDefinition;
use Scribe\Component\DataTransferObject\TransferManager\ObjectTransferManager;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Doctrine\Entity\Node\NodeRevision;
use Scribe\Tests\Component\DataTransferObject\TransferManager\Fixture\NodeFixture;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

/**
 * Class ObjectTransferManagerTest.
 */
class ObjectTransferManagerTest extends AbstractMantleTestCase
{
    /**
     * @var Node
     */
    public $node;

    /**
     * @var NodeRevision
     */
    public $revision;

    public function setUp()
    {
        parent::setUp();

        $this->node = new Node();
        $this->revision = (new NodeRevision())
            ->setAuthor('First Last')
            ->setContent('Content')
        ;
    }

    public function testConstructorWithFixtureUsage()
    {
        $createdOn = new \DateTime();
        $updatedOn = new \DateTime();

        $this
            ->node
            ->setAuthor('First Last')
            ->setTitle('The Title')
            ->setWeight(50)
            ->setCreatedOn($createdOn)
            ->setUpdatedOn($updatedOn)
        ;

        $nodeFake = new NodeFixture();

        $def = new ObjectMappingDefinition(false, [
            'doesnt-exist' => null,
            'author' => 'the_author',
            'title' => 'node_title',
            'weight' => 'node_weight',
            'created_on' => 'createdOn',
            'updated_on' => 'updatedOn',
            'ending-bad-property' => 'wont-be-transferred',
            'another-invalid-property' => 'nothing'
        ]);

        $transferManager = new ObjectTransferManager($def);
        $nodeFakeResult = $transferManager->getMappedObject($this->node, $nodeFake);

        $expectedNodeFaker = new NodeFixture();
        $expectedNodeFaker
            ->setAuthor('First Last')
            ->setTitle('The Title')
            ->setWeight(50)
            ->setCreatedOn($createdOn)
            ->setUpdatedOn($updatedOn)
        ;

        $this->assertEquals($expectedNodeFaker, $nodeFakeResult);
    }

    public function testConstructorGreedyWithFixtureUsage()
    {
        $createdOn = new \DateTime();
        $updatedOn = new \DateTime();
        $revisions = new ArrayCollection([$this->revision]);
        $containerNodeRevisions = new ArrayCollection([]);

        $this
            ->node
            ->setAuthor('First Last')
            ->setRevisions($revisions)
            ->setLatestRevision($this->revision)
            ->setContainerNodeRevisions($containerNodeRevisions)
            ->setTitle('The Title')
            ->setWeight(50)
            ->setMaterializedPath('material-path')
            ->setCreatedOn($createdOn)
            ->setUpdatedOn($updatedOn)
        ;

        $nodeFake = new NodeFixture();

        $def = new ObjectMappingDefinition(true, [
            'doesnt-exist' => null,
            'author' => 'the_author',
            'another-invalid-property' => 'nothing',
            'title' => 'node_title',
            'weight' => 'node_weight',
            'created_on' => 'createdOn',
            'updated_on' => 'updatedOn',
            'ending-bad-property' => 'wont-be-transferred'
        ]);

        $transferManager = new ObjectTransferManager($def);
        $nodeFakeResult = $transferManager->getMappedObject($this->node, $nodeFake);

        $expectedNodeFaker = new NodeFixture();
        $expectedNodeFaker
            ->setAuthor('First Last')
            ->setRevisions($revisions)
            ->setLatestRevision($this->revision)
            ->setContainerNodeRevisions($containerNodeRevisions)
            ->setTitle('The Title')
            ->setWeight(50)
            ->setMaterializedPath('material-path')
            ->setCreatedOn($createdOn)
            ->setUpdatedOn($updatedOn)
        ;

        $this->assertEquals($expectedNodeFaker, $nodeFakeResult);
    }

    public function testMappingException()
    {
        $def = new ObjectMappingDefinition(true, [
            'doesnt-exist' => null,
            'author' => 'the_author',
            'another-invalid-property' => 'nothing',
            'title' => 'node_title',
            'weight' => 'node_weight',
            'created_on' => 'createdOn',
            'updated_on' => 'updatedOn',
            'ending-bad-property' => 'wont-be-transferred'
        ]);

        $this->setExpectedException(
            '\Scribe\Exception\InvalidArgumentException',
            'The method Scribe\Component\DataTransferObject\TransferManager\ObjectTransferManager::getMappedObject expects to be passed two objects.'
        );

        $transferManager = new ObjectTransferManager($def);
        $transferManager->getMappedObject($this->node, 'not-an-obj');
    }
}
