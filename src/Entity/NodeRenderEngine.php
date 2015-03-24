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

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NodeRenderEngine
 * @package Scribe\MantleBundle\Entity
 */
class NodeRenderEngine
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $closure;
    
    /**
     * @var ArrayCollection 
     */
    private $revisions;

    /**
     * perform any entity setup
     */
    public function __construct()
    {
        $this->revisions = new ArrayCollection;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return NodeRenderEngine
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set closure
     *
     * @param string $closure
     * @return NodeRenderEngine
     */
    public function setClosure($closure)
    {
        $this->closure = $closure;

        return $this;
    }

    /**
     * Get closure
     *
     * @return string 
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * Gets the value of revisions
     *
     * @return revisions
     */
    public function getRevisions()
    {
        return $this->revisions;
    }

    /**
     * Sets the value of revisions
     *
     * @param ArrayCollection 
     *
     * @return $this
     */
    public function setRevisions(ArrayCollection $revisions)
    {
        $this->revisions = $revisions;

        return $this;
    }
}
