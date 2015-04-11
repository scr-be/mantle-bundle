<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Mutator;

use Scribe\Exception\ExceptionInterface;
use Scribe\Exception\RuntimeException;

/**
 * Class HierarchicalRelationshipException.
 */
class HierarchicalRelationshipException extends RuntimeException implements ExceptionInterface
{
    /**
     * Exception code for an unknown/missing entity.
     *
     * @var int
     */
    const CODE_MISSING_ENTITY = 201;
}

/* EOF */
