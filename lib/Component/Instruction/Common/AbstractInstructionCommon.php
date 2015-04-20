<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Instruction\Common;
use Scribe\Utility\ClassInfo;
use Scribe\Exception\RuntimeException;
use Scribe\Exception\Model\ExceptionInterface;

/**
 * Class AbstractInstructionCommon.
 */
abstract class AbstractInstructionCommon implements InstructionCommonInterface
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) sprintf(
            '[Instruction] Type: "%s", Class: "%s", Name: "%s".',
            (string) $this->getType(),
            (string) $this->getSelf(),
            (string) ($this->hasName() ? $this->getName() : 'Undefined')
        );
    }

    /**
     * @param mixed $what
     * @param array $arguments
     *
     * @return mixed
     */
    abstract public function __call($what, array $arguments = []);

    /**
     * @param mixed $what
     * @param mixed $to
     *
     * @return mixed
     */
    abstract public function __set($what, $to);

    /**
     * @param mixed $what
     *
     * @return mixed
     */
    abstract public function __get($what);

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasName()
    {
        return (bool) (empty($name) !== true ?: false);
    }

    /**
     * @return string
     */
    public function getSelf()
    {
        return (string) get_class($this);
    }

    /**
     * @return string
     */
    public function getType()
    {
        $namespaceSet = ClassInfo::getNamespaceSetByInstance($this);

        if (false === (count_array($namespaceSet) > 0)) {
            throw new RuntimeException(
                'Could not determine the instruction type of "%s".',
                ExceptionInterface::CODE_GENERIC_FROM_MANTLE_LIB,
                null,
                null,
                (string) $this->getSelf()
            );
        }

        return array_last($namespaceSet);
    }
}

/* EOF */
