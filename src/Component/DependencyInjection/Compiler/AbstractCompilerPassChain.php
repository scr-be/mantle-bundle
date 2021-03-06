<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\DependencyInjection\Compiler;

use Scribe\Wonka\Utility\Mapper\ParametersToPropertiesMapperTrait;

/**
 * Class AbstractCompilerPassChain.
 */
abstract class AbstractCompilerPassChain implements CompilerPassChainInterface
{
    use ParametersToPropertiesMapperTrait;
    use CompilerPassChainTrait;

    /**
     * Construct object with default parameters. Any number of parameters may be passed so long as they are each a
     * single-element associative array of the form [propertyName=>propertyValue]. If passed, these additional
     * parameters will overwrite the default instance properties and, as such, the chain runtime handling.
     *
     * @param array[] ...$parameters
     */
    public function __construct(...$parameters)
    {
        $this->handlers = [];
        $this->filterMode = CompilerPassChainInterface::FILTER_MODE_FIRST;
        $this->restrictions = [
            CompilerPassChainInterface::RESTRICTION_INTERFACE_DEFAULT,
        ];

        $this->assignPropertyCollectionToSelf(...$parameters);
    }
}

/* EOF */
