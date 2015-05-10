<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Component\DataTransferObject\MappingDefinition;

use Scribe\Component\DataTransferObject\MappingDefinition\ObjectMappingDefinition;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

/**
 * Class ObjectMappingDefinitionTest.
 */
class ObjectMappingDefinitionTest extends AbstractMantleTestCase
{
    /**
     * @var \stdClass
     */
    public $from;

    public function setUp()
    {
        parent::setUp();

        $this->from = new Node();
    }

    public function testConstructorUsage()
    {
        $def = new ObjectMappingDefinition(false, [
            'doesnt-exist' => null,
            'parentNode' => 'parent_node',
            'childNodes' => 'child_nodes'
        ]);

        $expected = [
            'parentNode' => 'parent_node',
            'childNodes' => 'child_nodes'
        ];

        $this->assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testVariadic()
    {
        $def = new ObjectMappingDefinition(false);
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo('doesnt-exist', 'parent_node', 'child_nodes', 'should-be-ignored')
        ;

        $expected = [
            'parentNode' => 'parent_node',
            'childNodes' => 'child_nodes'
        ];

        $this->assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testEmptyTo()
    {
        $def = new ObjectMappingDefinition(false);
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo()
        ;

        $expected = [
            'parentNode' => 'parentNode',
            'childNodes' => 'childNodes'
        ];

        $this->assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testInvalidObject()
    {
        $def = new ObjectMappingDefinition(false);

        $this->assertEquals([], $def->getTransferable('not-an-object'));
    }

    public function testNoProperties()
    {
        $def = new ObjectMappingDefinition(false);
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo()
        ;

        $this->assertEquals([], $def->getTransferable(new \stdClass()));
    }

    public function testGreedy()
    {
        $def = new ObjectMappingDefinition();
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo('doesnt-exist', 'parent_node', 'child_nodes', 'should-be-ignored')
        ;

        $expected = [
            'parentNode' => 'parent_node',
            'childNodes' => 'child_nodes',
            'author' => 'author',
            'revisions' => 'revisions',
            'latestRevision' => 'latestRevision',
            'containerNodeRevisions' => 'containerNodeRevisions',
            'id' => 'id',
            'autoInitializationEnabled' => 'autoInitializationEnabled',
            'autoInitializationCalled' => 'autoInitializationCalled',
            'autoInitializationMethods' => 'autoInitializationMethods',
            'title' => 'title',
            'weight' => 'weight',
            'materializedPath' => 'materializedPath',
            'slug' => 'slug',
            'created_on' => 'created_on',
            'updated_on' => 'updated_on'
        ];

        $this->assertEquals($expected, $def->getTransferable($this->from));
    }
}
