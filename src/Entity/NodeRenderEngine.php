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
    private $service;
    
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
     * Set service
     *
     * @param string $service
     * @return NodeRenderEngine
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string 
     */
    public function getService()
    {
        return $this->service;
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
