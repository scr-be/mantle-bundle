<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model;

use Scribe\MantleBundle\Entity\Icon;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasIcon.
 */
trait HasIconsOwningSide
{
    /**
     * @var Icon[]
     */
    private $icons;

    /**
     * Init trait.
     */
    public function initializeIcons()
    {
        $this->icons = new ArrayCollection();
    }

    /**
     * Setter for icons collection.
     *
     * @param ArrayCollection $icons
     *
     * @return $this
     */
    public function setIcons(ArrayCollection $icons = null)
    {
        $this->icons = $icons;

        return $this;
    }

    /**
     * Getter for icons collection.
     *
     * @return ArrayCollection
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * Checker for icons collection.
     *
     * @return bool
     */
    public function hasIcons()
    {
        return (bool) ($this->icons > 0);
    }

    /**
     * Nullify icons collection.
     *
     * @return $this
     */
    public function clearIcons()
    {
        $this->icons = new ArrayCollection();

        return $this;
    }
}

/* EOF */
