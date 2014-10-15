<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

use Scribe\SharedBundle\Entity\Icon;

/**
 * Class HasIcon
 *
 * @package Scribe\SharedBundle\Entity\Template
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
