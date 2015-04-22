<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Exception\Model;

use Scribe\Exception\Model\ExceptionInterface;

/**
 * Interface ORMExceptionInterface.
 */
interface ORMExceptionInterface extends ExceptionInterface
{
    /**
     * @var string
     */
    const MSG_ORM_GENERIC = 'An undefined ORM exception was thrown.';

    /**
     * @var int
     */
    const CODE_ORM_GENERIC = 5000;

    /**
     * @var string
     */
    const MSG_ORM_TRANSACTION = 'An error occurred while during a transaction or when committing it: %s.';

    /**
     * @var int
     */
    const CODE_ORM_TRANSACTION = 5010;

    /**
     * @var string
     */
    const MSG_ORM_SUBSCRIBER_GENERIC = 'An error during an ORM subscriber operation: %s.';

    /**
     * @var int
     */
    const CODE_ORM_SUBSCRIBER_GENERIC = 5020;

    /**
     * @var string
     */
    const MSG_ORM_SUBSCRIBER_EVENT = 'An error during an the "%s" ORM subscriber event operation: %s.';

    /**
     * @var int
     */
    const CODE_ORM_SUBSCRIBER_EVENT = 5021;

    /**
     * @var string
     */
    const MSG_ORM_STATE_DATA_GENERIC = 'An ORM data state is incorrect or otherwise inconsistent: %s.';

    /**
     * @var int
     */
    const CODE_ORM_STATE_DATA_GENERIC = 5030;

    /**
     * @var string
     */
    const MSG_ORM_STATE_ASSOCIATION_GENERIC = 'An ORM association state is incorrect or otherwise inconsistent: %s.';

    /**
     * @var int
     */
    const CODE_ORM_STATE_ASSOCIATION_GENERIC = 5031;

    /**
     * Exception message for an unknown/missing entity.
     *
     * @var string
     */
    const MSG_ORM_STATE_ENTITY_MISSING = 'An invalid/unknown/missing entity "%s" was requested: %s.';

    /**
     * Exception code for an unknown/missing entity.
     *
     * @var int
     */
    const CODE_ORM_STATE_ENTITY_MISSING = 5040;
}

/* EOF */
