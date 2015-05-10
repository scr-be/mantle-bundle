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

use Scribe\Component\DataTransferObject\MappingDefinition\ObjectMappingDefinitionInterface;

/**
 * Class ObjectTransferManagerInterface.
 */
interface ObjectTransferManagerInterface
{
    /**
     * Set custom object property mapping.
     *
     * @param ObjectMappingDefinitionInterface|null $mapping
     *
     * @return $this
     */
    public function setMappingDefinition(ObjectMappingDefinitionInterface $mapping = null);

    /**
     * @param object $from
     * @param object $to
     *
     * @return object
     */
    public function getMappedObject($from, $to);
}

/* EOF */
