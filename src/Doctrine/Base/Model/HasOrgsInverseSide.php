<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Component\Security\Core\OrganizationInterface;

/**
 * Class HasOrgsInverseSide.
 */
trait HasOrgsInverseSide
{
    /**
     * Organization collection property.
     *
     * @var ArrayCollection
     */
    protected $orgs;

    /**
     * Initialize orgs as {@see ArrayCollection}.
     */
    public function initializeOrgs()
    {
        $this->orgs = new ArrayCollection();
    }

    /**
     * Get org collection.
     *
     * @return ArrayCollection
     */
    public function getOrgs()
    {
        return $this->orgs;
    }

    /**
     * Check for orgs.
     *
     * @return bool
     */
    public function hasOrgs()
    {
        return (bool) ($this->orgs->count() > 0 ?: false);
    }

    /**
     * @param OrganizationInterface $org
     *
     * @return bool
     */
    public function hasOrg(OrganizationInterface $org)
    {
        return (true === $this->orgs->contains($org) ?: false);
    }

    /**
     * @param OrganizationInterface $org
     *
     * @return $this
     */
    public function addOrg(OrganizationInterface $org)
    {
        if (false === $this->hasOrg($org)) {
            $this->orgs->add($org);
        }

        return $this;
    }
}

/* EOF */
