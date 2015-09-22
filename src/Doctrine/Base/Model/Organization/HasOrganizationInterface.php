<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Organization;

use Scribe\MantleBundle\Component\Security\Core\OrganizationInterface;

/**
 * Class HasOrganization.
 */
interface HasOrganizationInterface
{
    /**
     * Setter for organization property.
     *
     * @param OrganizationInterface|null $organization An organization entity object instance.
     *
     * @return $this
     */
    public function setOrganization(OrganizationInterface $organization = null);

    /**
     * Getter for organization property.
     *
     * @return OrganizationInterface|null
     */
    public function getOrganization();

    /**
     * Checker for organization property.
     *
     * @return bool
     */
    public function hasOrganization();

    /**
     * Nullify the organization property.
     *
     * @return $this
     */
    public function clearOrganization();

    /**
     * Setter for organization property.
     *
     * @param OrganizationInterface|null $org a organization entity object instance
     *
     * @return $this
     *
     * @deprecated
     */
    public function setOrg(OrganizationInterface $org = null);

    /**
     * Getter for organization property.
     *
     * @return OrganizationInterface|null
     *
     * @deprecated
     */
    public function getOrg();

    /**
     * Checker for organization property.
     *
     * @return bool
     *
     * @deprecated
     */
    public function hasOrg();

    /**
     * Nullify the organization property.
     *
     * @return $this
     *
     * @deprecated
     */
    public function clearOrg();
}

/* EOF */
