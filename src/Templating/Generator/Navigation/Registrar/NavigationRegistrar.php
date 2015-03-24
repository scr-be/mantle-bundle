<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Navigation\Registrar;

use Scribe\MantleBundle\Templating\Generator\Navigation\Member\NavigationMemberInterface;

/**
 * NavigationRegistrar.
 */
class NavigationRegistrar implements NavigationRegistrarInterface
{
    /**
     * @var NavigationMemberInterface[]
     */
    protected $members = [ ];

    /**
     * Add member to navigation registrar (configured via tagged DI services).
     *
     * @param NavigationMemberInterface $member
     */
    public function addMember(NavigationMemberInterface $member)
    {
        $this->members[ ] = $member;
    }
}

/* EOF */
