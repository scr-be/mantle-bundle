<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility\Mapper;

use Scribe\Utility\Mapper\ParametersToPropertiesMapperTrait;

/**
 * Class MapperFixture.
 */
class MapperFixture
{
    use ParametersToPropertiesMapperTrait;

    /**
     * @var string
     */
    private $propertyString;

    /**
     * @var int
     */
    private $propertyInt;

    /**
     * @var mixed
     */
    private $someOtherRandomProperty;

    public function __construct($parameters)
    {
        $this->assignPropertyCollectionToSelf(...$parameters);
    }

    /**
     * @return string
     */
    public function getPropertyString()
    {
        return $this->propertyString;
    }

    /**
     * @param string $propertyString
     */
    public function setPropertyString($propertyString)
    {
        $this->propertyString = $propertyString;
    }

    /**
     * @return int
     */
    public function getPropertyInt()
    {
        return $this->propertyInt;
    }

    /**
     * @param int $propertyInt
     */
    public function setPropertyInt($propertyInt)
    {
        $this->propertyInt = $propertyInt;
    }

    /**
     * @return mixed
     */
    public function getSomeOtherRandomProperty()
    {
        return $this->someOtherRandomProperty;
    }

    /**
     * @param mixed $someOtherRandomProperty
     */
    public function setSomeOtherRandomProperty($someOtherRandomProperty)
    {
        $this->someOtherRandomProperty = $someOtherRandomProperty;
    }

    public function exposedAssignPropertyCollectionToSelf(array ...$parameters)
    {
        $this->assignPropertyCollectionToSelf(...$parameters);
    }
}

/* EOF */
