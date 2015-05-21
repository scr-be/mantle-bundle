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

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class TokenAwareTrait.
 */
trait TokenAwareTrait
{
    /**
     * @var TokenInterface|null
     */
    protected $token = null;

    /**
     * Setter for token.
     *
     * @param TokenInterface|null $token token instance
     *
     * @return $this
     */
    public function setToken(TokenInterface $token = null)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Getter for token.
     *
     * @return TokenInterface|null
     */
    public function getToken()
    {
        return $this->token;
    }
}

/* EOF */
