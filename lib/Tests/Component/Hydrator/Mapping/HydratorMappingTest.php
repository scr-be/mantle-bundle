<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Component\Hydrator\Mapping;

use Scribe\Component\Hydrator\Mapping\HydratorMapping;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

/**
 * Class HydratorMappingTest.
 */
class HydratorMappingTest extends AbstractMantleTestCase
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
        $def = new \Scribe\Component\Hydrator\Mapping\HydratorMapping(false, [
            'doesnt-exist' => null,
            'parentNode' => 'parent_node',
            'childNodes' => 'child_nodes',
        ]);

        $expected = [
            'parentNode' => 'parent_node',
            'childNodes' => 'child_nodes',
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testVariadic()
    {
        $def = new HydratorMapping(false);
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo('doesnt-exist', 'parent_node', 'child_nodes', 'should-be-ignored')
        ;

        $expected = [
            'parentNode' => 'parent_node',
            'childNodes' => 'child_nodes',
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testEmptyTo()
    {
        $def = new HydratorMapping(false);
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo()
        ;

        $expected = [
            'parentNode' => 'parentNode',
            'childNodes' => 'childNodes',
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }

    public function testInvalidObject()
    {
        $def = new HydratorMapping(false);

        static::assertEquals([], $def->getTransferable('not-an-object'));
    }

    public function testNoProperties()
    {
        $def = new HydratorMapping(false);
        $def
            ->setMappingFrom('doesnt-exist', 'parentNode', 'childNodes', 'childNodes')
            ->setMappingTo()
        ;

        static::assertEquals([], $def->getTransferable(new \stdClass()));
    }

    public function testGreedy()
    {
        $def = new HydratorMapping();
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
            'updated_on' => 'updated_on',
        ];

        static::assertEquals($expected, $def->getTransferable($this->from));
    }
}
