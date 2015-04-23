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

use Scribe\Utility\Magic\MagicPropertyMapperAwareTrait;

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
    private $handlerCollection;

    /**
     * Force handler to implement more specific interface/subclass.
     *
     * @var string|null
     */
    private $handlerInstanceRestriction;

    /**
     * Construct object using
     *
     * @param mixed ...$parameters
     */
    public function __construct(...$parameters)
    {
        $this->handlerCollection = [];
        $this->handlerInstanceRestriction = null;

        foreach ($parameters as $p) {
            $this->mapHashToPropertiesByAssignment($p);
        }
    }

    /**
     * Basic implementation of the compiler pass add handler.
     *
     * @param CompilerPassHandlerInterface $handler
     * @param int|null                     $priority
     */
    public function addHandler(CompilerPassHandlerInterface $handler, $priority = null)
    {
        $handlerInstanceRestriction = $this->handlerInstanceRestriction;
        if ($handlerInstanceRestriction !== null && false === ($handler instanceof $handlerInstanceRestriction)) {
            return;
        }

        $this->handlerCollection[(int) $priority] = $handler;
    }

    /**
     * Basic implementation of the get handler based on criteria passed.
     *
     * @param string ...$by
     *
     * @return CompilerPassHandlerInterface|null
     */
    public function getHandler(...$by)
    {
        ksort($this->handlerCollection);

        foreach ($this->handlerCollection as $handler) {
            if (true === $handler->isSupported(...$by)) {
                return $handler;
            }
        }

        return null;
    }
}

/* EOF */
