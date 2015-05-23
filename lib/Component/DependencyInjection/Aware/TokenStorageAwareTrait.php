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

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class TokenStorageAwareTrait.
 */
trait TokenStorageAwareTrait
{
    /**
     * @var TokenStorageInterface|null
     */
    protected $tokenStorage = null;

    /**
     * @param TokenStorageInterface|null $tokenStorage
     *
     * @return $this
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage = null)
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    /**
     * @return TokenStorageInterface|null
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }
}

/* EOF */
