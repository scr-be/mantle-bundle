<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Aware;

use Scribe\Doctrine\Manager\EntityManagerProxyInterface;

/**
 * Class EntityManagerHandlerAwareTrait.
 */
trait EntityManagerProxyAwareTrait
{
    /**
     * @var EntityManagerProxyInterface|null
     */
    protected $manager = null;

    /**
     * @param EntityManagerProxyInterface|null $manager
     *
     * @return $this
     */
    public function setManagerProxy(EntityManagerProxyInterface $manager = null)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return EntityManagerProxyInterface|null
     */
    public function getManagerProxy()
    {
        return $this->manager;
    }
}

/* EOF */
