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
    protected $org;

    /**
     * Init organization property.
     */
    public function initializeOrg()
    {
        $this->org = null;
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
        $this->org = $organization;

        return $this;
    }

    /**
     * Getter for organization property.
     *
     * @return OrganizationInterface|null
     */
    public function getOrganization()
    {
        return $this->org;
    }

    /**
     * Checker for organization property.
     *
     * @return bool
     */
    public function hasOrganization()
    {
        return (bool) ($this->org instanceof OrganizationInterface);
    }

    /**
     * Nullify the organization property.
     *
     * @return $this
     */
    public function clearOrganization()
    {
        $this->org = null;

        return $this;
    }

    /**
     * Setter for organization property.
     *
     * @param OrganizationInterface|null $org a organization entity object instance
     *
     * @return $this
     *
     * @deprecated
     */
    public function setOrg(OrganizationInterface $org = null)
    {
        return $this->setOrganization($org);
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
