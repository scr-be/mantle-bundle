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
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasSlug;

/**
 * NodeRenderEngine
 * @package Scribe\MantleBundle\Entity
 */
class NodeRenderEngine extends AbstractEntity
{
    use HasSlug;

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
        parent::__construct();

        $this->revisions = new ArrayCollection;
    }

    /**
     * Support for casting from object to string
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ':' . $this->getSlug();
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

    /**
     * Renders the $content with the appropriate
     * rendering engine
     *
     * @param Symfony service
     * @param string
     * @param array
     * @return string 
     */
    public function render($service, $content, $args)
    {
        $function = $this->getClosure();
        $content = $function($service, $content, $args);

        return $content;
    }
}
