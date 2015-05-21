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

use Scribe\Doctrine\Manager\EntityManagerForwardableInterface;

/**
 * Class EntityManagerHandlerAwareTrait.
 */
trait EntityManagerForwardableAwareTrait
{
    /**
     * @var EntityManagerForwardableInterface|null
     */
    protected $manager = null;

    /**
     * Setter for manager.
     *
     * @param EntityManagerForwardableInterface|null $manager manager instance
     *
     * @return $this
     */
    public function setManagerForwardable(EntityManagerForwardableInterface $manager = null)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Getter for manager.
     *
     * @return EntityManagerForwardableInterface|null
     */
    public function getManagerForwardable()
    {
        return $this->manager;
    }
}

/* EOF */
