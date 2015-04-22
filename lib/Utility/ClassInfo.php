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

use Scribe\Exception\BadFunctionCallException;
use Scribe\Exception\InvalidArgumentException;
use Scribe\Exception\Model\ExceptionInterface;
use Scribe\Utility\Caller\Call;
use Scribe\Utility\StaticClass\StaticClassTrait;

/**
 * Class ClassInfo.
 */
class ClassInfo
{
    use StaticClassTrait;

    /**
     * Constant to request namespace from generic get method.
     *
     * @var string
     */
    const NAMESPACE_STR = 'Namespace';

    /**
     * Constant to request namespace using class instance from generic get method.
     *
     * @var string
     */
    const NAMESPACE_STR_BY_INSTANCE = 'NamespaceByInstance';

    /**
     * Constant to request namespace set from generic get method.
     *
     * @var string
     */
    const NAMESPACE_SET = 'NamespaceSet';

    /**
     * Constant to request namespace set using class instance from generic get method.
     *
     * @var string
     */
    const NAMESPACE_SET_BY_INSTANCE = 'NamespaceSetByInstance';

    /**
     * Constant to request number of namespace levels from generic get method.
     *
     * @var string
     */
    const NAMESPACE_LEVELS = 'NamespaceLevels';

    /**
     * Constant to request number of namespace levels using class instance from generic get method.
     *
     * @var string
     */
    const NAMESPACE_LEVELS_BY_INSTANCE = 'NamespaceLevelsByInstance';

    /**
     * Constant to request class name from generic method.
     *
     * @var string
     */
    const CLASS_STR = 'ClassName';

    /**
     * Constant to request class name using class instance from generic method.
     *
     * @var string
     */
    const CLASS_STR_BY_INSTANCE = 'ClassNameByInstance';

    /**
     * @param string $fqcn
     * @param string $what
     *
     * @return mixed
     *
     * @throws ExceptionInterface
     */
    public static function get($fqcn, $what = self::CLASS_STR)
    {
        $exceptionCaught = null;

        try {
            return Call::staticMethod(__CLASS__, 'get' . $what, $fqcn);
        } catch (InvalidArgumentException $e) {
            $exceptionCaught = $e;
        } catch (BadFunctionCallException $e) {
            $exceptionCaught = $e;
        }

        if ($exceptionCaught instanceof ExceptionInterface) {
            throw $exceptionCaught;
        }
    }

    /**
     * @param object $instance
     * @param string $what
     *
     * @return mixed
     */
    public static function getByInstance($instance, $what = self::CLASS_STR)
    {
        return self::get(get_class($instance), $what);
    }

    /**
     * Get the namespace of the provided class
     *
     * @param string $fqcn
     *
     * @return string
     */
    public static function getNamespace($fqcn)
    {
        $className = self::getClassName($fqcn);

        return (string) str_replace($className, '', $fqcn);
    }

    /**
     * Get the namespace of the provided class instance
     *
     * @param object $instance
     *
     * @return string
     */
    public static function getNamespaceByInstance($instance)
    {
        return (string) self::getNamespace(get_class($instance));
    }

    /**
     * Get the namespace parts of the provided class
     *
     * @param string $fqcn
     * @param int    $limit
     *
     * @return array
     */
    public static function getNamespaceSet($fqcn, $limit = -1)
    {
        return (array) explode('\\', $fqcn, $limit);
    }

    /**
     * Returns the namespace array from the class instance.
     *
     * @param object $instance
     *
     * @return array
     */
    public static function getNamespaceSetByInstance($instance)
    {
        return (array) self::getNamespaceSet(get_class($instance));
    }

    /**
     * Get the number of namespace levels for the class.
     *
     * @param string $fqcn
     *
     * @return int
     */
    public static function getNamespaceLevels($fqcn)
    {
        return (int) count(self::getNamespaceSet($fqcn));
    }

    /**
     * Get the number of namespace levels for the class instance.
     *
     * @param object $instance
     *
     * @return int
     */
    public static function getNamespaceLevelsByInstance($instance)
    {
        return (int) self::getNamespaceSet(get_class($instance));
    }

    /**
     * Attempt to return just the class name (without a namespace) for the given fully-qualified class name.
     *
     * @param string $fqcn Fully-qualified class name
     *
     * @return string
     */
    public static function getClassName($fqcn)
    {
        return (string) array_last(self::getNamespaceSet($fqcn, 1000));
    }

    /**
     * Returns the class name from the provided class instance.
     *
     * @param object $instance
     *
     * @return string
     */
    public static function getClassNameByInstance($instance)
    {
        return (string) self::getClassName(get_class($instance));
    }

    /**
     * Attempt to return just the trait name (without a namespace) for the given fully-qualified trait name.
     *
     * @param string $fqtn
     *
     * @return string
     */
    public static function getTraitName($fqtn)
    {
        return (string) ClassInfo::getClassName($fqtn);
    }
}

/* EOF */
