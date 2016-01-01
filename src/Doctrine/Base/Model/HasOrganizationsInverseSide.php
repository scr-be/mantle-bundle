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
 * Class HasOrganizationsInverseSide.
 */
trait HasOrganizationsInverseSide
{
    /**
     * Organization collection property.
     *
     * @var ArrayCollection
     */
    protected $organizations;

    /**
     * Initialize orgs as {@see ArrayCollection}.
     */
    public function initializeOrganizations()
    {
        $this->organizations = new ArrayCollection();
    }

    /**
     * Get org collection.
     *
     * @return ArrayCollection
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * Check for orgs.
     *
     * @return bool
     */
    public function hasOrganizations()
    {
        return (bool) (!$this->organizations->isEmpty());
    }

    /**
     * @param OrganizationInterface $organization
     *
     * @return bool
     */
    public function hasOrganization(OrganizationInterface $organization)
    {
        return (bool) $this->organizations->contains($organization);
    }

    /**
     * @param OrganizationInterface $organization
     *
     * @return $this
     */
    public function addOrganization(OrganizationInterface $organization)
    {
        if (!$this->hasOrganization($organization)) {
            $this->organizations->add($organization);
        }

        return $this;
    }
}

/* EOF */
