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

/**
 * Class HasTitle
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasTitle
{
    /**
     * The title property
     *
     * @type string
     */
    protected $title;

    /**
     * Setter for title property
     *
     * @param string|null $title your title string
     * @return $this
     */
    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getter for title property
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Checker for title property
     *
     * @return bool
     */
    public function hasTitle()
    {
        return (bool) ($this->getTitle() !== null);
    }

    /**
     * Nullify the title property
     *
     * @return $this
     */
    public function unsetTitle()
    {
        $this->setTitle(null);

        return $this;
    }
}
