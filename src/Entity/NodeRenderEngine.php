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
}
