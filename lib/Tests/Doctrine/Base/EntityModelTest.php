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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Doctrine\Entity\Icon\Icon;
use Scribe\MantleBundle\Doctrine\Entity\Icon\IconFamily;
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

    /**
     * @var AbstractEntity
     */
    private $randomEntityOne;

    /**
     * @var AbstractEntity
     */
    private $randomEntityTwo;

    /**
     * @var array
     */
    private $basicTraitAssertions = [
        'HasAlias' => [
            'props' => ['alias'],
            'methods' => ['initializeAlias', 'setAlias', 'getAlias', 'hasAlias', 'clearAlias'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Alias!'],
        ],
        'HasAliases' => [
            'props' => ['aliases'],
            'methods' => ['initializeAliases', 'setAliases', 'getAliases', 'hasAliases', 'clearAliases'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasAttributes' => [
            'props' => ['attributes'],
            'methods' => ['initializeAttributes', 'setAttributes', 'getAttributes', 'hasAttributes', 'clearAttributes'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasProperties' => [
            'props' => ['properties'],
            'methods' => ['initializeProperties', 'setProperties', 'getProperties', 'hasProperties', 'clearProperties'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasCategories' => [
            'props' => ['categories'],
            'methods' => ['initializeCategories', 'setCategories', 'getCategories', 'hasCategories', 'clearCategories'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasCode' => [
            'props' => ['code'],
            'methods' => ['initializeCode', 'setCode', 'getCode', 'hasCode', 'clearCode'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Code!'],
        ],
        'HasContext' => [
            'props' => ['context'],
            'methods' => ['initializeContext', 'setContext', 'getContext', 'hasContext', 'clearContext'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Context!'],
        ],
        'HasCount' => [
            'props' => ['count'],
            'methods' => ['initializeCount', 'setCount', 'getCount', 'hasCount', 'clearCount'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [-20, 0, 1000, 99, 38299201, 302, 3232, 4353, 34, 5, 0, 222],
        ],
        'HasDescription' => [
            'props' => ['description'],
            'methods' => ['initializeDescription', 'setDescription', 'getDescription', 'hasDescription', 'clearDescription'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Description!'],
        ],
        'HasName' => [
            'props' => ['name'],
            'methods' => ['initializeName', 'setName', 'getName', 'hasName', 'clearName'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Name!'],
        ],
        'HasParameters' => [
            'props' => ['parameters'],
            'methods' => ['initializeParameters', 'setParameters', 'getParameters', 'hasParameters', 'clearParameters'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [['1', '2', '3'], [1, 2, 3], [['a', 1], 0, 4], ['Some random String']],
        ],
        'HasTitle' => [
            'props' => ['title'],
            'methods' => ['initializeTitle', 'setTitle', 'getTitle', 'hasTitle', 'clearTitle'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Title!'],
        ],
        'HasValue' => [
            'props' => ['value'],
            'methods' => ['initializeValue', 'setValue', 'getValue', 'hasValue', 'clearValue'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Value!'],
        ],
        'HasVersion' => [
            'props' => ['version'],
            'methods' => ['initializeVersion', 'setVersion', 'getVersion', 'hasVersion', 'clearVersion'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['123', 'something', 'anotherThing', 'This Is An Version!'],
        ],
        'HasWeight' => [
            'props' => ['weight'],
            'methods' => ['initializeWeight', 'setWeight', 'getWeight', 'hasWeight', 'clearWeight'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [10, 1, 5, 2, 9303, 2222, 3],
        ],
        'HasPersonHonorific' => [
            'props' => ['honorific'],
            'methods' => ['initializeHonorific', 'setHonorific', 'getHonorific', 'hasHonorific', 'clearHonorific'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['Mr.', 'Mr.', 'Mr.', 'Prof.', 'Mrs.'],
        ],
        'HasPersonFirstName' => [
            'props' => ['firstName'],
            'methods' => ['initializeFirstName', 'setFirstName', 'getFirstName', 'hasFirstName', 'clearFirstName'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['Rob', 'Dan', 'Andrew', 'David', 'Chrissy'],
        ],
        'HasPersonMiddleName' => [
            'props' => ['middleName'],
            'methods' => ['initializeMiddleName', 'setMiddleName', 'getMiddleName', 'hasMiddleName', 'clearMiddleName'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['Martin', 'F', 'H', 'Alan', 'M'],
        ],
        'HasPersonSurname' => [
            'props' => ['surname'],
            'methods' => ['initializeSurname', 'setSurname', 'getSurname', 'hasSurname', 'clearSurname'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['Frawley', 'Corrigan', 'Thomas', 'Rech', 'Chimi'],
        ],
        'HasPersonSuffix' => [
            'props' => ['suffix'],
            'methods' => ['initializeSuffix', 'setSuffix', 'getSuffix', 'hasSuffix', 'clearSuffix'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['2nd', 'Sr.', 'I', 'Sr.', 'I'],
        ],
        'HasLead' => [
            'props' => ['lead'],
            'methods' => ['initializeLead', 'setLead', 'getLead', 'hasLead', 'clearLead'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [
                'This is a text lead.',
                'And another one.',
            ],
        ],
        'HasContent' => [
            'props' => ['content'],
            'methods' => ['initializeContent', 'setContent', 'getContent', 'hasContent', 'clearContent'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [
                'This is text content.',
                'And another one.',
            ],
        ],
        'HasImportance' => [
            'props' => ['importance'],
            'methods' => ['initializeImportance', 'setImportance', 'getImportance', 'hasImportance', 'clearImportance'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [-10, 0, 10, 20, 30, 40],
        ],
        'HasSlug' => [
            'props' => ['slug'],
            'methods' => ['initializeSlug', 'setSlug', 'getSlug', 'hasSlug', 'clearSlug'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => ['a-slug', 'second', 'some-really-long-slug', 'yeah---slug'],
        ],
        'HasParentOwningSide' => [
            'props' => ['parent'],
            'methods' => ['initializeParent', 'setParent', 'getParent', 'hasParent', 'clearParent'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [],
        ],
        'HasChildrenOwningSide' => [
            'props' => ['children'],
            'methods' => ['initializeChildren', 'setChildren', 'getChildren', 'hasChildren', 'clearChildren'],
            'op' => [self::RUNTIME_OPERATIONS_CRUD],
            'ops' => [],
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

        static::assertTrue(method_exists($entity, '__toString'));
        static::assertEquals('Scribe\Tests\Doctrine\Fixtures\BaseEntity', (string) $entity);
        static::assertTrue(method_exists($entity, '__toArray'));
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
        static::assertTrue($entity->hasAlias('key'));
        static::assertFalse($entity->hasAlias('doesn-have-key'));
        static::assertEquals('value', $entity->getAlias('key'), 'Should return the value to the key.');
        $entity->clearAliases();
        static::assertFalse($entity->hasAlias('key'));
        static::assertNull($entity->getAlias('key'));

        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasAttributes()
    {
        $trait = 'HasAttributes';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $entity->setAttributes(['key' => 'value']);
        static::assertTrue($entity->hasAttributeKey('key'));
        static::assertTrue($entity->hasAttributeValue('value'));
        static::assertFalse($entity->hasAttributeKey('doesn-have-key'));
        static::assertFalse($entity->hasAttributeValue('doesn-have-this-value'));
        static::assertEquals('value', $entity->getAttributeValue('key'), 'Should return the value to the key.');
        $entity->setAttributeValue('key', 'different-value', false);
        static::assertTrue($entity->hasAttributeKey('key'));
        static::assertTrue($entity->hasAttributeValue('value'));
        $entity->setAttributeValue('key', 'different-value', true);
        static::assertFalse($entity->hasAttributeValue('value'));
        static::assertTrue($entity->hasAttributeKey('key'));
        static::assertTrue($entity->hasAttributeValue('different-value'));
        $entity->clearAttributes();
        static::assertFalse($entity->hasAttributeKey('key'));
        static::assertFalse($entity->hasAttributeValue('value'));
        static::assertFalse($entity->hasAttributeValue('different-value'));
        static::assertNull($entity->getAttributeValue('key'));

        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasProperties()
    {
        $trait = 'HasProperties';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $entity->setProperties(['key' => 'value']);
        static::assertTrue($entity->hasPropertyKey('key'));
        static::assertTrue($entity->hasPropertyValue('value'));
        static::assertFalse($entity->hasPropertyKey('doesn-have-key'));
        static::assertFalse($entity->hasPropertyValue('doesn-have-this-value'));
        static::assertEquals('value', $entity->getPropertyValue('key'), 'Should return the value to the key.');
        $entity->setPropertyValue('key', 'different-value', false);
        static::assertTrue($entity->hasPropertyKey('key'));
        static::assertTrue($entity->hasPropertyValue('value'));
        $entity->setPropertyValue('key', 'different-value', true);
        static::assertFalse($entity->hasPropertyValue('value'));
        static::assertTrue($entity->hasPropertyKey('key'));
        static::assertTrue($entity->hasPropertyValue('different-value'));
        $entity->clearProperties();
        static::assertFalse($entity->hasPropertyKey('key'));
        static::assertFalse($entity->hasPropertyValue('value'));
        static::assertFalse($entity->hasPropertyValue('different-value'));
        static::assertNull($entity->getPropertyValue('key'));

        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasCategories()
    {
        $trait = 'HasCategories';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $entity->setCategories(['key' => 'value']);
        static::assertTrue($entity->hasCategory('key'));
        static::assertFalse($entity->hasCategory('doesn-have-key'));
        static::assertEquals('value', $entity->getCategory('key'), 'Should return the value to the key.');
        $entity->clearCategories();
        static::assertFalse($entity->hasCategory('key'));
        static::assertNull($entity->getCategory('key'));

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
        static::assertEquals(5001, $entity->getCount());
        $entity->incrementCount(28);
        static::assertEquals(5029, $entity->getCount());
        $entity->decrementCount();
        static::assertEquals(5028, $entity->getCount());
        $entity->decrementCount(100);
        static::assertEquals(4928, $entity->getCount());
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
        static::assertTrue($entity->hasParameterKey('key'));
        static::assertTrue($entity->hasParameterValue('value'));
        static::assertFalse($entity->hasParameterKey('doesn-have-key'));
        static::assertFalse($entity->hasParameterValue('doesn-have-this-value'));
        static::assertEquals('value', $entity->getParameterValue('key'), 'Should return the value to the key.');
        $entity->setParameterValue('key', 'different-value', false);
        static::assertTrue($entity->hasParameterKey('key'));
        static::assertTrue($entity->hasParameterValue('value'));
        $entity->setParameterValue('key', 'different-value', true);
        static::assertFalse($entity->hasParameterValue('value'));
        static::assertTrue($entity->hasParameterKey('key'));
        static::assertTrue($entity->hasParameterValue('different-value'));
        $entity->clearParameters();
        static::assertFalse($entity->hasParameterKey('key'));
        static::assertFalse($entity->hasParameterValue('value'));
        static::assertFalse($entity->hasParameterValue('different-value'));
        static::assertNull($entity->getParameterValue('key'));
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

        static::assertEquals('Mr. Rob Martin Frawley 2nd', $entity->getFullName());
        static::assertEquals('Rob Frawley', $entity->getShortName());

        $entity = new BaseEntityHasPerson();
        $entity
            ->setFirstName('Dan')
            ->setMiddleName('F')
            ->setSurname('Corrigan')
        ;

        static::assertEquals('Dan F Corrigan', $entity->getFullName());
        static::assertEquals('Dan Corrigan', $entity->getShortName());
    }

    public function testEntityTraitHasLead()
    {
        $trait = 'HasLead';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasContent()
    {
        $trait = 'HasContent';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasImportance()
    {
        $trait = 'HasImportance';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $entity->setImportance($entity->getImportanceLevelByName('CRITICAL'));
        static::assertEquals(40, $entity->getImportance());

        static::assertNull($entity->getImportanceLevelByName('BADNAME'));
        static::assertEquals('DEPRECATION', $entity->getImportanceLevelByInt(-10));
        static::assertNull($entity->getImportanceLevelByInt(-10000));

        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasSlug()
    {
        $trait = 'HasSlug';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasParentOwningSide()
    {
        $this->randomEntityOne = new IconFamily();
        $this->randomEntityOne->setName('family');
        $this->randomEntityTwo = new Icon();
        $this->randomEntityTwo->setName('icon');
        $this->basicTraitAssertions['HasParentOwningSide']['ops'] = [
            $this->randomEntityOne,
            $this->randomEntityTwo,
        ];
        $trait = 'HasParentOwningSide';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);
        $this->clearEntityAfterTest();
    }

    public function testEntityTraitHasChildrenOwningSide()
    {
        $this->randomEntityOne = new IconFamily();
        $this->randomEntityOne->setName('family');
        $this->randomEntityTwo = new Icon();
        $this->randomEntityTwo->setName('icon');
        $this->basicTraitAssertions['HasChildrenOwningSide']['ops'] = [new ArrayCollection([
            $this->randomEntityOne,
            $this->randomEntityTwo,
            ]),
        ];
        $trait = 'HasChildrenOwningSide';
        $entity = $this->setEntityBeforeTest($trait);
        $this->performRuntime($trait, $entity);

        $collection = new ArrayCollection([
            $this->randomEntityOne,
            $this->randomEntityTwo,
        ]);
        $entity->setChildren($collection);

        static::assertTrue($entity->hasChild($this->randomEntityOne));

        $entity->addChild($this->randomEntityOne);
        static::assertEquals(2, $entity->getChildren()->count());
        $entity->addChild($this->randomEntityOne, false);
        static::assertEquals(3, $entity->getChildren()->count());
        $entity->removeChild($this->randomEntityTwo);
        static::assertEquals(2, $entity->getChildren()->count());
        $this->clearEntityAfterTest();
    }

    private function performRuntime($traitName, $entity)
    {
        $config = $this->basicTraitAssertions[$traitName];

        if (true !== array_key_exists('namespace', $config)) {
            $this->reflectionAnalyser->setRequireFQN(false);
        }

        static::assertTrue($this->reflectionAnalyser->hasTrait($traitName));

        foreach ($config['props'] as $property) {
            static::assertTrue($this->reflectionAnalyser->hasProperty($property));
        }

        foreach ($config['methods'] as $method) {
            static::assertTrue($this->reflectionAnalyser->hasMethod($method), 'Should have method '.$method);
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
        $setter = $config['methods'][1];
        $getter = $config['methods'][2];
        $checker = $config['methods'][3];
        $clearer = $config['methods'][4];

        static::assertEmpty($entity->$getter(), 'Property should be empty prior to initialization.');
        $entity->$initializer();

        for ($i = 0; $i < count($config['ops']); $i++) {
            static::assertFalse($entity->$checker());
            $entity->$setter($config['ops'][$i]);
            static::assertEquals($config['ops'][$i], $entity->$getter(),
                sprintf(
                    'Property should have value of "%s".',
                    (is_array($config['ops'][$i]) ? print_r($config['ops'][$i], true) : $config['ops'][$i])
                )
            );
            static::assertTrue($entity->$checker());
            $entity->$clearer();
            static::assertFalse($entity->$checker());
        }
    }
}

/* EOF */
