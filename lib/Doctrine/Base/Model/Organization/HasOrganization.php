<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Organization;

use Scribe\MantleBundle\Component\Security\Core\OrganizationInterface;

/**
 * Class HasOrganization.
 */
trait HasOrganization
{
    /**
     * @var OrganizationInterface
     */
    protected $organization;

    /**
     * Init organization property.
     */
    public function initializeOrg()
    {
        $this->organization = null;
    }

    /**
     * Setter for organization property.
     *
     * @param OrganizationInterface|null $organization An organization entity object instance.
     *
     * @return $this
     */
    public function setOrganization(OrganizationInterface $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Getter for organization property.
     *
     * @return OrganizationInterface|null
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Checker for organization property.
     *
     * @return bool
     */
    public function hasOrganization()
    {
        return (bool) ($this->organization instanceof OrganizationInterface);
    }

    /**
     * Nullify the organization property.
     *
     * @return $this
     */
    public function clearOrganization()
    {
        $this->organization = null;

        return $this;
    }

    /**
     * Setter for organization property.
     *
     * @param OrganizationInterface|null $organization a organization entity object instance
     *
     * @return $this
     *
     * @deprecated
     */
    public function setOrg(OrganizationInterface $organization = null)
    {
        return $this->setOrganization($organization);
    }

    /**
     * Getter for organization property.
     *
     * @return OrganizationInterface|null
     *
     * @deprecated
     */
    public function getOrg()
    {
        return $this->getOrganization();
    }

    /**
     * Checker for organization property.
     *
     * @return bool
     *
     * @deprecated
     */
    public function hasOrg()
    {
        return $this->hasOrganization();
    }

    /**
     * Nullify the organization property.
     *
     * @return $this
     *
     * @deprecated
     */
    public function clearOrg()
    {
        return $this->clearOrganization();
    }
}

/* EOF */
