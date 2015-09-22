<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\DependencyInjection\Aware;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class AuthCheckerAwareTrait.
 */
trait AuthCheckerAwareTrait
{
    /**
     * @var AuthorizationCheckerInterface|null
     */
    protected $authChecker = null;

    /**
     * @param AuthorizationCheckerInterface|null $authChecker
     *
     * @return $this
     */
    public function setAuthChecker(AuthorizationCheckerInterface $authChecker = null)
    {
        $this->authChecker = $authChecker;

        return $this;
    }

    /**
     * @return AuthorizationCheckerInterface|null
     */
    public function getAuthChecker()
    {
        return $this->authChecker;
    }
}

/* EOF */
