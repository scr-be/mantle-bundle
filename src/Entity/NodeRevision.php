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
 * NodeRevision
 * @package Scribe\MantleBundle\Entity
 */
class NodeRevision
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \stdClass
     */
    private $author;

    /**
     * @var \stdClass
     */
    private $renderEngine;

    /**
     * @var \stdClass
     */
    private $embeddedNodes;

    /**
     * @var \stdClass
     */
    private $embeddedAssets;


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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return NodeRevision
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime 
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return NodeRevision
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     * @return NodeRevision
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \stdClass 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set renderEngine
     *
     * @param \stdClass $renderEngine
     * @return NodeRevision
     */
    public function setRenderEngine($renderEngine)
    {
        $this->renderEngine = $renderEngine;

        return $this;
    }

    /**
     * Get renderEngine
     *
     * @return \stdClass 
     */
    public function getRenderEngine()
    {
        return $this->renderEngine;
    }

    /**
     * Set embeddedNodes
     *
     * @param \stdClass $embeddedNodes
     * @return NodeRevision
     */
    public function setEmbeddedNodes($embeddedNodes)
    {
        $this->embeddedNodes = $embeddedNodes;

        return $this;
    }

    /**
     * Get embeddedNodes
     *
     * @return \stdClass 
     */
    public function getEmbeddedNodes()
    {
        return $this->embeddedNodes;
    }

    /**
     * Set embeddedAssets
     *
     * @param \stdClass $embeddedAssets
     * @return NodeRevision
     */
    public function setEmbeddedAssets($embeddedAssets)
    {
        $this->embeddedAssets = $embeddedAssets;

        return $this;
    }

    /**
     * Get embeddedAssets
     *
     * @return \stdClass 
     */
    public function getEmbeddedAssets()
    {
        return $this->embeddedAssets;
    }
}
