<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasTitle;
use Scribe\Doctrine\Base\Model\HasWeight;
use Scribe\Doctrine\Base\Model\HasIconAsString;
use Scribe\Doctrine\Base\Model\HasAttrs;
use Scribe\Doctrine\Base\Model\HasRouteName;
use Scribe\Doctrine\Base\Model\HasRouteParameters;
use Scribe\Doctrine\Base\Model\HasParentOwningSide;
use Scribe\Doctrine\Base\Model\HasRoleRestrictionsAsArrayOwningSide;
use Scribe\Doctrine\Base\Model\HasReverseRoleRestrictionsAsArrayOwningSide;

/**
 * Entity NavMenuSubItem.
 */
class NavMenuSubItem extends AbstractEntity
{
    use HasTitle,
        HasWeight,
        HasIconAsString,
        HasAttrs,
        HasRouteName,
        HasRouteParameters,
        HasParentOwningSide,
        HasRoleRestrictionsAsArrayOwningSide,
        HasReverseRoleRestrictionsAsArrayOwningSide;

    /**
     * @var boolean
     */
    private $header;

    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__.':'.$this->routeName;
    }

    /**
     * Setup entity.
     */
    public function __construct()
    {
        parent::__construct();

        $this->header = false;
    }

    /**
     * @param boolean $header
     *
     * @return NavMenuSubItem
     */
    public function setHeader($header = null)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return boolean
     */
    public function isHeader()
    {
        return $this->header ?
            true : false
        ;
    }

    /**
     * @return boolean
     */
    public function hasSubItems()
    {
        return false;
    }
}

/* EOF */
