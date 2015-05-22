<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Hydrator\Manager;

use Scribe\Component\Hydrator\Mapping\HydratorMappingInterface;

/**
 * Class HydratorManagerInterface.
 */
interface HydratorManagerInterface
{
    /**
     * Set custom object property mapping.
     *
     * @param \Scribe\Component\Hydrator\Mapping\HydratorMappingInterface|null $mapping
     *
     * @return $this
     */
    public function setMapping(HydratorMappingInterface $mapping = null);

    /**
     * @param object $from
     * @param object $to
     *
     * @return object
     */
    public function getMappedObject($from, $to);
}

/* EOF */
