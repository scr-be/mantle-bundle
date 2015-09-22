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

use Scribe\MantleBundle\Doctrine\Exception\ORMException;

/**
 * Class HierarchicalRelationshipException.
 */
class HierarchicalRelationshipException extends ORMException
{
    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_ORM_STATE_ENTITY_MISSING;
    }

    /**
     * Get the default exception code.
     *
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_ORM_STATE_ENTITY_MISSING;
    }
}

/* EOF */
