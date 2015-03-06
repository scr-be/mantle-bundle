<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Template;

use Scribe\MantleBundle\Entity\Icon;

/**
 * Class HasIcon
 *
 * @package Scribe\MantleBundle\Entity\Template
 */
trait HasIcon
{
    /**
     * The icon property
     *
     * @type Icon
     */
    protected $icon;

    /**
     * Setter for icon property
     *
     * @param Icon $icon any Icon object instance
     * @return $this
     */
    public function setIcon(Icon $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Getter for icon property
     *
     * @return Icon|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Checker for icon property
     *
     * @return bool
     */
    public function hasIcon()
    {
        return (bool)$this->icon instanceof Icon;
    }

    /**
     * Nullify the icon property
     *
     * @return $this
     */
    public function clearIcon()
    {
        $this->icon = null;

        return $this;
    }
}

/* EOF */
