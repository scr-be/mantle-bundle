<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\RepositoryAware;

/**
 * Interface NodeRepositoryAwareInterface.
 */
interface NodeRepositoryAwareInterface
{
    /**
     * @param string $field
     * @param string $criteria
     * @param \Exception $exception
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function throwNotFoundEntityException($field, $criteria, \Exception $exception);
}

/* EOF */
