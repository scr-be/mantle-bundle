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
     * @var NodeRevisionDiff 
     */
    private $diff;

    /**
     * @var Scribe\MantleBundle\Entity\Node 
     */
    private $owningNode;

    /**
     * @var Scribe\MantleBundle\Entity\Node 
     */
    private $node;

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

    /**
     * Gets the value of diff
     *
     * @return NodeRevisionDiff|null 
     */
    public function getdiff()
    {
        return $this->diff;
    }

    /**
     * Sets the value of diff
     *
     * @param NodeRevisionDiff
     *
     * @return $this 
     */
    public function setDiff(NodeRevisionDiff $diff)
    {
        $this->diff = $diff;
        return $this;
    }

    /**
     * Gets the value of owningNode
     *
     * @return Scribe\MantleBundle\Entity\Node 
     */
    public function getOwningNode()
    {
        return $this->owningNode;
    }

    /**
     * Sets the value of owningNode
     *
     * @param Scribe\MantleBundle\Entity\Node
     *
     * @return $this 
     */
    public function setOwningNode(Scribe\MantleBundle\Entity\Node $owningNode)
    {
        $this->owningNode = $owningNode;
        return $this;
    }

    /**
     * Gets the value of node
     *
     * @return Scribe\MantleBundle\Entity\Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Sets the value of node
     *
     * @param Scribe\MantleBundle\Entity\Node
     *
     * @return $this
     */
    public function setNode(Scribe\MantleBundle\Entity\Node $node)
    {
        $this->node = $node;

        return $this;
    }
}
