<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Compiler;

use Scribe\Exception\RuntimeException;
use Scribe\Utility\ClassInfo;
use Scribe\Utility\Magic\MagicPropertyMapperAwareTrait;
use SebastianBergmann\Environment\Runtime;

/**
 * Class AbstractCompilerPassChain.
 */
abstract class AbstractCompilerPassChain implements CompilerPassChainInterface
{
    use MagicPropertyMapperAwareTrait;

    /**
     * Collection of handler object instances registered to this chain.
     *
     * @var CompilerPassHandlerInterface[]
     */
    private $handlers;

    /**
     * Force handler to implement more specific interface/subclass.
     *
     * @var string|null
     */
    private $restrictions;

    /**
     * The mode to use when returning the result of {@see getHandler()}.
     *
     * @var int
     */
    private $filterMode;

    /**
     * Construct object with default parameters. Any number of parameters may be passed so long as they are each a
     * single-element associative array of the form [propertyName=>propertyValue]. If passed, these additional
     * parameters will overwrite the default instance properties and, as such, the chain runtime handling.
     *
     * @param array[] ...$parameters
     */
    public function __construct(...$parameters)
    {
        $this->handlers     = [];
        $this->restrictions = [];
        $this->filterMode   = self::FILTER_MODE_FIRST;

        $this->assignPropertyCollectionToSelf($parameters);
    }

    /**
     * Sets the handlers using the passed array. The array key is used as the priority and the array value must
     * be an instance of a handler
     *
     * @param array $handlerCollection
     *
     * @return $this
     */
    public function setHandlerCollection(array $handlerCollection = [])
    {
        $this->clearHandlerCollection();

        foreach ($handlerCollection as $handler) {
            $this->addHandler($handler);
        }

        return $this;
    }

    /**
     * Gets the array of registered chain handlers.
     *
     * @return array
     */
    public function getHandlerCollection()
    {
        return (array) $this->handlerCollection;
    }

    /**
     * Gets the array of registered chain handlers after filtering them using the provided callable.
     *
     * @param callable $filterCallable
     *
     * @return array
     */
    public function getHandlerCollectionFiltered(callable $filterCallable)
    {
        return (array) array_filter($this->handlerCollection, $filterCallable);
    }

    /**
     * Checks if any handlers have been attached to this chains collection.
     *
     * @return bool
     */
    public function hasHandlerCollection()
    {
        return (bool) (empty($this->handlerCollection) === true ?: false);
    }

    /**
     * Clear the handler collection array.
     *
     * @return $this
     */
    public function clearHandlerCollection()
    {
        $this->handlerCollection = [];

        return $this;
    }

    /**
     * Basic implementation of the compiler pass add handler.
     *
     * @param CompilerPassHandlerInterface $handler
     * @param int|null                     $priority
     *
     * @return $this
     */
    public function addHandler(CompilerPassHandlerInterface $handler, $priority = null)
    {
        if (false === $this->isHandlerValid($handler)) {
            return $this;
        }

        $this->handlerCollection[$this->determineHandlerPriority($priority)] = $handler;
        ksort($this->handlerCollection);

        return $this;
    }

    /**
     * Filters the handler collection based on their response to the passed criteria and then returns the resulting
     * handler(s) based on the filter mode set for the chain. These modes are defined in {@see CompilerPassChainInterface}
     * as constants and allow for three modes of operation: 1. Return the first supported handler; 2. Return the last
     * supported handler; 3. Return a handler only if the collection has been filtered down to a single item.
     *
     * @param mixed ...$by
     *
     * @throws RuntimeException If the mode {@see CompilerPassChainInterface::FILTER_MODE_SINGLE} is set and the filtered
     *                          handler collection contains more than one array element.
     *
     * @return CompilerPassHandlerInterface|null
     */
    public function getHandler(...$by)
    {
        $filteredCollection = $this->getHandlerCollectionFiltered(function(CompilerPassHandlerInterface $handler) use ($by) {
            return (bool) $handler->isSupported(...$by);
        });

        return true === empty($filteredCollection) ?
            null : $this->getHandlerByMode($filteredCollection);
    }

    /**
     * Helper function for {@see getHandlerByMode} for mode {@see CompilerPassChainInterface::FILTER_MODE_SINGLE}.
     *
     * @param array $filteredHandlerCollection
     *
     * @throws RuntimeException When passed collection contains more than a single array element.
     *
     * @return mixed
     */
    private function getHandlerByModeSingle(array $filteredHandlerCollection)
    {
        if (1 !== count($filteredHandlerCollection)) {
            throw new RuntimeException(
                'More than one handler contained in collection but the chain type "%s" is configured to allow '.
                'only a single handler to meet a given requirement, as passed to "%s::getHandler".', null, null, null,
                ClassInfo::getClassNameByInstance($this), get_class($this)
            );
        }

        return array_first($filteredHandlerCollection);
    }

    /**
     * Checks if the passed handler has been added to this chains collection.
     *
     * @param CompilerPassHandlerInterface $handler
     *
     * @return bool
     */
    public function hasHandler(CompilerPassHandlerInterface $handler)
    {
        return (bool) (false === array_search($handler, $this->handlerCollection) ?: true);
    }

    /**
     * Checks if the passed handler class name has exists within this chain collection.
     *
     * @param string $search
     *
     * @return bool
     */
    public function hasHandlerType($search)
    {
        $handlerCollection = array_filter($this->handlerCollection, function(CompilerPassHandlerInterface $handler) use ($search) {
            return (bool) ($search === ClassInfo::getClassNameByInstance($handler) ?: false);
        });

        return (bool) (false === empty($handlerCollection) ?: false);
    }

    /**
     * Returns a single handler from the passed handler collection based on the set filter mode. For more information
     * about available modes reference {@see getHandler()} documentation.
     *
     * @param array $filteredHandlerCollection
     *
     * @return CompilerPassHandlerInterface|null
     */
    private function getHandlerByMode(array $filteredHandlerCollection)
    {
        switch ($this->handlerFilterMode) {
            case self::FILTER_MODE_FIRST:

                return $this->getHandlerByModeFirst($filteredHandlerCollection);

            case self::FILTER_MODE_LAST:

                return $this->getHandlerByModeLast($filteredHandlerCollection);

            case self::FILTER_MODE_SINGLE:
            default:

                return $this->getHandlerByModeSingle($filteredHandlerCollection);
        }
    }

    /**
     * Helper function for {@see getHandlerByMode} for mode {@see CompilerPassChainInterface::FILTER_MODE_FIRST}.
     *
     * @param array $filteredHandlerCollection
     *
     * @return CompilerPassHandlerInterface
     */
    private function getHandlerByModeFirst(array $filteredHandlerCollection)
    {
        return array_first($filteredHandlerCollection);
    }

    /**
     * Helper function for {@see getHandlerByMode} for mode {@see CompilerPassChainInterface::FILTER_MODE_LAST}.
     *
     * @param array $filteredHandlerCollection
     *
     * @return CompilerPassHandlerInterface
     */
    private function getHandlerByModeLast(array $filteredHandlerCollection)
    {
        return array_last($filteredHandlerCollection);
    }

    /**
     * Checks if the passed handler is valid based on the optional "instanceof" restriction set.
     *
     * @param CompilerPassHandlerInterface $handler
     *
     * @return bool
     */
    private function isHandlerValid(CompilerPassHandlerInterface $handler)
    {
        $restriction = $this->handlerRestriction;

        if (null === $restriction) {
            return true;
        }

        return (bool) ($handler instanceof $restriction);
    }

    /**
     * Get a valid priority. If a priority is tagged for the service, that value is returned, otherwise it returns a
     * priority beginning at the internal priority start value.
     *
     * @param mixed $priority
     *
     * @return int
     */
    private function determineHandlerPriority($priority)
    {
        static $priorityInternal = self::PRIORITY_INTERNAL_START;

        if (null === $priority) {
            $priority = $priorityInternal++;
        }

        return (int) $priority;
    }
}

/* EOF */
