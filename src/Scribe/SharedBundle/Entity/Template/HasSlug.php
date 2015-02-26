<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

/**
 * Class HasSlug
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasSlug
{
    /**
     * The slug property
     *
     * @type string
     */
    protected $slug;

    /**
     * Setter for slug property
     *
     * @param string|null $slug the slug string
     * @return $this
     */
    public function setSlug($slug = null)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Getter for slug property
     *
     * @return string|null
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Checker for slug property
     *
     * @return bool
     */
    public function hasSlug()
    {
        return (bool) ($this->slug !== null);
    }

    /**
     * Nullify the slug property
     *
     * @return $this
     */
    public function clearSlug()
    {
        $this->slug = null;

        return $this;
    }
}
