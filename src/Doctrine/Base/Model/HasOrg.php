<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Scribe\MantleBundle\Component\Security\Core\OrgInterface;

/**
 * Class HasOrganization.
 */
trait HasOrg
{
    /**
     * The entity organization property.
     *
     * @var OrgInterface
     */
    protected $org;

    /**
     * Init organization.
     */
    public function initializeOrg()
    {
        $this->org = null;
    }

    /**
     * Setter for organization property.
     *
     * @param OrgInterface|null $org a organization entity object instance
     *
     * @return $this
     */
    public function setOrg(OrgInterface $org = null)
    {
        $this->org = $org;

        return $this;
    }

    /**
     * Getter for organization property.
     *
     * @return OrgInterface|null
     */
    public function getOrg()
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
        return (bool) $this->org instanceof OrgInterface;
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
}

/* EOF */
