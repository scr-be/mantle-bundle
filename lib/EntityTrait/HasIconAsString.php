<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\EntityTrait;

use Scribe\MantleBundle\Entity\Icon;

/**
 * Class HasIcon
 *
 * @package Scribe\EntityTrait
 */
trait HasIconAsString
{
    /**
     * The icon property
     *
     * @type Icon
     */
    protected $icon;

    /**
     * init trait
     */
    protected function initIcon()
    {
        $this->icon = null;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return boolean
     */
    public function hasIcon()
    {
        return (bool) ($this->icon !== null ? true : false);
    }
}

/* EOF */
