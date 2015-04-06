<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility;

use Scribe\Exception\InvalidArgumentException;
use Scribe\Utility\StaticClass\StaticClassTrait;

/**
 * Class String.
 */
class ClassName
{
    /*
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * Attempt to return an array of the namespace parts for the given fully-qualified class name.
     *
     * @param string $fqcn Fully-qualified class name
     *
     * @return array
     *
     * @throws InvalidArgumentException If it cannot determine namespace parts
     */
    public static function getNamespaceArray($fqcn)
    {
        $namespaceParts = explode('\\', $fqcn);

        if (!is_array($namespaceParts) || false === (count($namespaceParts) > 0)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Could not parse namespace parts from provided fully-qualified class name %s.',
                    $fqcn
                )
            );
        }

        return (array) $namespaceParts;
    }

    /**
     * Attempt to return just the class name (without a namespace) for the given fully-qualified class name.
     *
     * @param string $fqcn Fully-qualified class name
     *
     * @return string
     *
     * @throws InvalidArgumentException If it cannot determine class name
     */
    public static function getClassNameString($fqcn)
    {
        $namespaceParts = ClassName::getNamespaceArray($fqcn);
        $className = implode(
            '',
            array_splice($namespaceParts, -1)
        );

        if (false === (strlen($className) > 0)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Could not parse classname from provided fully-qualified class name %s.',
                    $fqcn
                )
            );
        }

        return (string) $className;
    }

    /**
     * Attempt to return just the trait name (without a namespace) for the given fully-qualified trait name.
     *
     * @param string $fqcn Fully-qualified class name
     *
     * @return string
     *
     * @throws InvalidArgumentException If it cannot determine class name
     */
    public static function getTraitNameString($fqn)
    {
        return (string) ClassName::getClassNameString($fqn);
    }
}

/* EOF */
