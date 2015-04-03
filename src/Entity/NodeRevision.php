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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;

/**
 * NodeRevision.
 */
class NodeRevision extends AbstractEntity
{
    /*
     * import traits
     */
    use TimestampableBehaviorTrait;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Scribe\MantleBundle\Model\AuthorInterface
     */
    private $author;

    /**
     * @var NodeRenderEngine
     */
    private $renderEngine;

    /**
     * @var ArrayCollection
     */
    private $embeddedNodes;

    /**
     * @var ArrayCollection
     */
    private $embeddedAssets;

    /**
     * @var NodeRevisionDiff
     */
    private $diff;

    /**
     * @var Node
     */
    private $owningNode;

    /**
     * @var Node
     */
    private $node;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        parent::__construct();

        $this->embeddedNodes  = new ArrayCollection();
        $this->embeddedAssets = new ArrayCollection();
    }

    /**
     * Support for casting from object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return NodeRevision
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set author.
     *
     * @param \stdClass $author
     *
     * @return NodeRevision
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \stdClass
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set renderEngine.
     *
     * @param \stdClass $renderEngine
     *
     * @return NodeRevision
     */
    public function setRenderEngine($renderEngine)
    {
        $this->renderEngine = $renderEngine;

        return $this;
    }

    /**
     * Get renderEngine.
     *
     * @return \stdClass
     */
    public function getRenderEngine()
    {
        return $this->renderEngine;
    }

    /**
     * Checks if renderEngine set
     *
     * @return renderEngine
     */
    public function hasRenderEngine()
    {
        return (bool) ($this->renderEngine !== null);
    }

    /**
     * Set embeddedNodes
     *
     * @param \stdClass $embeddedNodes
     *
     * @return NodeRevision
     */
    public function setEmbeddedNodes($embeddedNodes)
    {
        $this->embeddedNodes = $embeddedNodes;

        return $this;
    }

    /**
     * Get embeddedNodes.
     *
     * @return \stdClass
     */
    public function getEmbeddedNodes()
    {
        return $this->embeddedNodes;
    }

    /**
     * Set embeddedAssets.
     *
     * @param \stdClass $embeddedAssets
     *
     * @return NodeRevision
     */
    public function setEmbeddedAssets($embeddedAssets)
    {
        $this->embeddedAssets = $embeddedAssets;

        return $this;
    }

    /**
     * Get embeddedAssets.
     *
     * @return \stdClass
     */
    public function getEmbeddedAssets()
    {
        return $this->embeddedAssets;
    }

    /**
     * Gets the value of diff.
     *
     * @return NodeRevisionDiff|null
     */
    public function getdiff()
    {
        return $this->diff;
    }

    /**
     * Sets the value of diff.
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
     * Gets the value of owningNode.
     *
     * @return Scribe\MantleBundle\Entity\Node
     */
    public function getOwningNode()
    {
        return $this->owningNode;
    }

    /**
     * Sets the value of owningNode.
     *
     * @param Scribe\MantleBundle\Entity\Node
     *
     * @return $this
     */
    public function setOwningNode(Node $owningNode)
    {
        $this->owningNode = $owningNode;

        return $this;
    }

    /**
     * Gets the value of node.
     *
     * @return Scribe\MantleBundle\Entity\Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Sets the value of node.
     *
     * @param Scribe\MantleBundle\Entity\Node
     *
     * @return $this
     */
    public function setNode(Node $node)
    {
        $this->node = $node;

        return $this;
    }
}
