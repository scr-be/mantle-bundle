<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DataTransferObject\TransferManager;

use Scribe\Component\DataTransferObject\MappingDefinition\ObjectMappingDefinition;
use Scribe\Component\DataTransferObject\MappingDefinition\ObjectMappingDefinitionInterface;
use Scribe\Exception\InvalidArgumentException;
use Scribe\Utility\Reflection\ClassReflectionAnalyser;

/**
 * Class ObjectTransferManager.
 */
class ObjectTransferManager implements ObjectTransferManagerInterface
{
    /**
     * @var ObjectMappingDefinitionInterface
     */
    protected $mapping;

    /**
     * Object can be instantiated with the mapping definition directly.
     *
     * @param ObjectMappingDefinitionInterface $mapping
     */
    public function __construct(ObjectMappingDefinitionInterface $mapping = null)
    {
        $this->setMappingDefinition(
            (null === $mapping ? new ObjectMappingDefinition() : $mapping)
        );
    }

    /**
     * Set custom object property mapping.
     *
     * @param ObjectMappingDefinitionInterface|null $mapping
     *
     * @return $this
     */
    public function setMappingDefinition(ObjectMappingDefinitionInterface $mapping = null)
    {
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * @param object $from
     * @param object $to
     *
     * @throws \Exception If $from or $to is not an object instance.
     *
     * @return object
     */
    public function getMappedObject($from, $to)
    {
        if (false === is_object($from) || false === is_object($to)) {
            throw new InvalidArgumentException(
                'The method %s expects to be passed two objects.',
                null, null, null,
                __METHOD__
            );
        }

        return $this->mapPropertyCollection(
            $from,
            $to,
            $this->mapping->getTransferable($from)
        );
    }

    /**
     * @param object $from
     * @param object $to
     * @param array  $propertyCollection
     *
     * @return object
     */
    protected function mapPropertyCollection($from, $to, array $propertyCollection)
    {
        $refFrom = (new ClassReflectionAnalyser())
            ->setReflectionClassFromClassInstance($from)
        ;

        $refTo = (new ClassReflectionAnalyser())
            ->setReflectionClassFromClassInstance($to)
        ;

        foreach ($propertyCollection as $fromProperty => $toProperty) {
            $this->mapProperty($refFrom, $refTo, $to, $from, $fromProperty, $toProperty);
        }

        return $to;
    }

    /**
     * @param ClassReflectionAnalyser $refFrom
     * @param ClassReflectionAnalyser $refTo
     * @param object                  $to
     * @param object                  $from
     * @param string                  $fromProperty
     * @param string                  $toProperty
     */
    protected function mapProperty(ClassReflectionAnalyser $refFrom, ClassReflectionAnalyser $refTo,
                                   &$to, $from, $fromProperty, $toProperty)
    {
        if (true !== $refFrom->hasProperty($fromProperty) ||
            true !== $refTo->hasProperty($toProperty)) {
            return;
        }

        $refFromProperty = $refFrom->setPropertyPublic($fromProperty);
        $refFromValue = $refFromProperty->getValue($from);

        $refToProperty = $refTo->setPropertyPublic($toProperty);
        $refToProperty->setValue($to, $refFromValue);
    }
}

/* EOF */
