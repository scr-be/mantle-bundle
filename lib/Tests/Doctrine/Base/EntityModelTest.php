<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity;

use Scribe\Tests\Doctrine\Fixtures\BaseEntity;
use Scribe\Tests\Doctrine\Fixtures\BaseEntityHasPerson;
use Scribe\Utility\Reflection\ClassReflectionAnalyser;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

/**
 * Class Entity.
 */
class EntityModelTest extends AbstractMantleTestCase
{
    const RUNTIME_OPERATIONS_CRUD = 'runBasicCRUDOperations';

    /**
     * @var ClassReflectionAnalyser
     */
    private $reflectionAnalyser;

    private $basicTraitAssertions = [
        'HasAlias' => [
            'props'   => ['alias'],
            'methods' => ['initializeAlias', 'setAlias', 'getAlias', 'hasAlias', 'clearAlias'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Alias!'],
        ],
        'HasAliases' => [
            'props'   => ['aliases'],
            'methods' => ['initializeAliases', 'setAliases', 'getAliases', 'hasAliases', 'clearAliases'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasAttributes' => [
            'props'   => ['attributes'],
            'methods' => ['initializeAttributes', 'setAttributes', 'getAttributes', 'hasAttributes', 'clearAttributes'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasCategories' => [
            'props'   => ['categories'],
            'methods' => ['initializeCategories', 'setCategories', 'getCategories', 'hasCategories', 'clearCategories'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasCode' => [
            'props'   => ['code'],
            'methods' => ['initializeCode', 'setCode', 'getCode', 'hasCode', 'clearCode'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Code!'],
        ],
        'HasContext' => [
            'props'   => ['context'],
            'methods' => ['initializeContext', 'setContext', 'getContext', 'hasContext', 'clearContext'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Context!'],
        ],
        'HasCount' => [
            'props'   => ['count'],
            'methods' => ['initializeCount', 'setCount', 'getCount', 'hasCount', 'clearCount'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => [-20, 0, 1000, 99, 38299201, 302, 3232, 4353, 34, 5, 0, 222],
        ],
        'HasDescription' => [
            'props'   => ['description'],
            'methods' => ['initializeDescription', 'setDescription', 'getDescription', 'hasDescription', 'clearDescription'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Description!'],
        ],
        'HasName' => [
            'props'   => ['name'],
            'methods' => ['initializeName', 'setName', 'getName', 'hasName', 'clearName'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Name!'],
        ],
        'HasParameters' => [
            'props'   => ['parameters'],
            'methods' => ['initializeParameters', 'setParameters', 'getParameters', 'hasParameters', 'clearParameters'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasTitle' => [
            'props'   => ['title'],
            'methods' => ['initializeTitle', 'setTitle', 'getTitle', 'hasTitle', 'clearTitle'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Title!'],
        ],
        'HasValue' => [
            'props'   => ['value'],
            'methods' => ['initializeValue', 'setValue', 'getValue', 'hasValue', 'clearValue'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Value!'],
        ],
        'HasVersion' => [
            'props'   => ['version'],
            'methods' => ['initializeVersion', 'setVersion', 'getVersion', 'hasVersion', 'clearVersion'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['123', 'something', 'anotherThing', 'This Is An Version!'],
        ],
        'HasWeight' => [
            'props'   => ['weight'],
            'methods' => ['initializeWeight', 'setWeight', 'getWeight', 'hasWeight', 'clearWeight'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => [10, 1, 5, 2, 9303, 2222, 3],
        ],
        'HasPersonHonorific' => [
            'props'   => ['honorific'],
            'methods' => ['initializeHonorific', 'setHonorific', 'getHonorific', 'hasHonorific', 'clearHonorific'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['Mr.', 'Mr.', 'Mr.', 'Prof.', 'Mrs.'],
        ],
        'HasPersonFirstName' => [
            'props'   => ['firstName'],
            'methods' => ['initializeFirstName', 'setFirstName', 'getFirstName', 'hasFirstName', 'clearFirstName'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['Rob', 'Dan', 'Andrew', 'David', 'Chrissy'],
        ],
        'HasPersonMiddleName' => [
            'props'   => ['middleName'],
            'methods' => ['initializeMiddleName', 'setMiddleName', 'getMiddleName', 'hasMiddleName', 'clearMiddleName'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['Martin', 'F', 'H', 'Alan', 'M'],
        ],
        'HasPersonSurname' => [
            'props'   => ['surname'],
            'methods' => ['initializeSurname', 'setSurname', 'getSurname', 'hasSurname', 'clearSurname'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['Frawley', 'Corrigan', 'Thomas', 'Rech', 'Chimi'],
        ],
        'HasPersonSuffix' => [
            'props'   => ['suffix'],
            'methods' => ['initializeSuffix', 'setSuffix', 'getSuffix', 'hasSuffix', 'clearSuffix'],
            'op'      => [self::RUNTIME_OPERATIONS_CRUD],
            'ops'     => ['2nd', 'Sr.', 'I', 'Sr.', 'I'],
        ],
    ];

    private function setEntityBeforeTest($traitName)
    {
        $entityName = 'Scribe\Tests\Doctrine\Fixtures\BaseEntity'.$traitName;
        $entity = new $entityName();
        $this->reflectionAnalyser->setReflectionClassFromClassName($entity);

        return $entity;
    }

    private function clearEntityAfterTest()
    {
        $this->reflectionAnalyser->unsetReflectionClass();
        $this->reflectionAnalyser->setRequireFQN(true);
    }

    public function setUp()
    {
        parent::setUp();

        $this->reflectionAnalyser = new ClassReflectionAnalyser();
    }

    public function testEntityIsCastable()
    {
        $entity = new BaseEntity();

        $this->assertTrue(method_exists($entity, '__toString'));
        $this->assertEquals('Scribe\Tests\Doctrine\Fixtures\BaseEntity', (string) $entity);
        $this->assertTrue(method_exists($entity, '__toArray'));
    }

    public function testEntityTraitHasAlias()
    {
        $trait = 'HasAlias';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasAliases()
    {
        $trait = 'HasAliases';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $entity->setAliases(['key' => 'value']);
        $this->assertTrue($entity->hasAlias('key'));
        $this->assertFalse($entity->hasAlias('doesn-have-key'));
        $this->assertEquals('value', $entity->getAlias('key'), 'Should return the value to the key.');
        $entity->clearAliases();
        $this->assertFalse($entity->hasAlias('key'));
        $this->assertNull($entity->getAlias('key'));

        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasAttributes()
    {
        $trait = 'HasAttributes';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $entity->setAttributes(['key' => 'value']);
        $this->assertTrue($entity->hasAttributeKey('key'));
        $this->assertTrue($entity->hasAttributeValue('value'));
        $this->assertFalse($entity->hasAttributeKey('doesn-have-key'));
        $this->assertFalse($entity->hasAttributeValue('doesn-have-this-value'));
        $this->assertEquals('value', $entity->getAttributeValue('key'), 'Should return the value to the key.');
        $entity->setAttributeValue('key', 'different-value', false);
        $this->assertTrue($entity->hasAttributeKey('key'));
        $this->assertTrue($entity->hasAttributeValue('value'));
        $entity->setAttributeValue('key', 'different-value', true);
        $this->assertFalse($entity->hasAttributeValue('value'));
        $this->assertTrue($entity->hasAttributeKey('key'));
        $this->assertTrue($entity->hasAttributeValue('different-value'));
        $entity->clearAttributes();
        $this->assertFalse($entity->hasAttributeKey('key'));
        $this->assertFalse($entity->hasAttributeValue('value'));
        $this->assertFalse($entity->hasAttributeValue('different-value'));
        $this->assertNull($entity->getAttributeValue('key'));

        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasCategories()
    {
        $trait = 'HasCategories';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $entity->setCategories(['key' => 'value']);
        $this->assertTrue($entity->hasCategory('key'));
        $this->assertFalse($entity->hasCategory('doesn-have-key'));
        $this->assertEquals('value', $entity->getCategory('key'), 'Should return the value to the key.');
        $entity->clearCategories();
        $this->assertFalse($entity->hasCategory('key'));
        $this->assertNull($entity->getCategory('key'));

        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasCode()
    {
        $trait = 'HasCode';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasContext()
    {
        $trait = 'HasContext';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasCount()
    {
        $trait = 'HasCount';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $entity->setCount(5000);
        $entity->incrementCount();
        $this->assertEquals(5001, $entity->getCount());
        $entity->incrementCount(28);
        $this->assertEquals(5029, $entity->getCount());
        $entity->decrementCount();
        $this->assertEquals(5028, $entity->getCount());
        $entity->decrementCount(100);
        $this->assertEquals(4928, $entity->getCount());
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasDescription()
    {
        $trait = 'HasDescription';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasName()
    {
        $trait = 'HasName';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasParameters()
    {
        $trait = 'HasParameters';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();

        $entity->setParameters(['key' => 'value']);
        $this->assertTrue($entity->hasParameterKey('key'));
        $this->assertTrue($entity->hasParameterValue('value'));
        $this->assertFalse($entity->hasParameterKey('doesn-have-key'));
        $this->assertFalse($entity->hasParameterValue('doesn-have-this-value'));
        $this->assertEquals('value', $entity->getParameterValue('key'), 'Should return the value to the key.');
        $entity->setParameterValue('key', 'different-value', false);
        $this->assertTrue($entity->hasParameterKey('key'));
        $this->assertTrue($entity->hasParameterValue('value'));
        $entity->setParameterValue('key', 'different-value', true);
        $this->assertFalse($entity->hasParameterValue('value'));
        $this->assertTrue($entity->hasParameterKey('key'));
        $this->assertTrue($entity->hasParameterValue('different-value'));
        $entity->clearParameters();
        $this->assertFalse($entity->hasParameterKey('key'));
        $this->assertFalse($entity->hasParameterValue('value'));
        $this->assertFalse($entity->hasParameterValue('different-value'));
        $this->assertNull($entity->getParameterValue('key'));
    }

    public function testEntityTraitHasTitle()
    {
        $trait = 'HasTitle';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasValue()
    {
        $trait = 'HasValue';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasVersion()
    {
        $trait = 'HasVersion';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasWeight()
    {
        $trait = 'HasWeight';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasPersonHonorific()
    {
        $trait = 'HasPersonHonorific';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasPersonFirstName()
    {
        $trait = 'HasPersonFirstName';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasPersonMiddleName()
    {
        $trait = 'HasPersonMiddleName';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasPersonSurname()
    {
        $trait = 'HasPersonSurname';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasPersonSuffix()
    {
        $trait = 'HasPersonSuffix';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasPerson()
    {
        $entity = new BaseEntityHasPerson();
        $entity
            ->setHonorific('Mr.')
            ->setFirstName('Rob')
            ->setMiddleName('Martin')
            ->setSurname('Frawley')
            ->setSuffix('2nd')
        ;

        $this->assertEquals('Mr. Rob Martin Frawley 2nd', $entity->getFullName());
        $this->assertEquals('Rob Frawley', $entity->getShortName());

        $entity = new BaseEntityHasPerson();
        $entity
            ->setFirstName('Dan')
            ->setMiddleName('F')
            ->setSurname('Corrigan')
        ;

        $this->assertEquals('Dan F Corrigan', $entity->getFullName());
        $this->assertEquals('Dan Corrigan', $entity->getShortName());
    }

    private function performRuntime($traitName, $entity)
    {
        $config = $this->basicTraitAssertions[$traitName];

        if (true !== array_key_exists('namespace', $config)) {
            $this->reflectionAnalyser->setRequireFQN(false);
        }

        $this->assertTrue($this->reflectionAnalyser->hasTrait($traitName));

        foreach ($config['props'] as $property) {
            $this->assertTrue($this->reflectionAnalyser->hasProperty($property));
        }

        foreach ($config['methods'] as $method) {
            $this->assertTrue($this->reflectionAnalyser->hasMethod($method), 'Should have method '.$method);
        }

        foreach ($config['op'] as $operation) {
            $this->$operation($traitName, $entity, $config);
        }
    }

    private function runBasicCRUDOperations($traitName, $entity, array $config)
    {
        if (count($config['methods']) !== 5) {
            $this->fail(sprintf('Incorrect fixture data for "%s" provided for "%s" operations.', $traitName, __FUNCTION__));
        }

        $initializer = $config['methods'][0];
        $setter      = $config['methods'][1];
        $getter      = $config['methods'][2];
        $checker     = $config['methods'][3];
        $clearer     = $config['methods'][4];

        $this->assertEmpty($entity->$getter(), 'Property should be empty prior to initialization.');
        $entity->$initializer();

        for ($i = 0; $i < count($config['ops']); $i++) {
            $this->assertFalse($entity->$checker());
            $entity->$setter($config['ops'][$i]);
            $this->assertEquals($config['ops'][$i], $entity->$getter(),
                sprintf(
                    'Property should have value of "%s".',
                    (is_array($config['ops'][$i]) ? print_r($config['ops'][$i], true) : $config['ops'][$i])
                )
            );
            $this->assertTrue($entity->$checker());
            $entity->$clearer();
            $this->assertFalse($entity->$checker());
        }
    }
}

/* EOF */
