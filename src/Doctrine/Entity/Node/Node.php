<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Node;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasTitle;
use Scribe\Doctrine\Base\Model\HasWeight;
use Scribe\Doctrine\Behavior\Model\Hierarchical\HierarchicalNodeBehaviorTrait;
use Scribe\Doctrine\Behavior\Model\Hierarchical\HierarchicalNodeInterface;
use Scribe\Doctrine\Behavior\Model\Loggable\LoggableBehaviorTrait;
use Scribe\Doctrine\Behavior\Model\Sluggable\SluggableBehaviorTrait;
use Scribe\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;

/**
 * Class Node.
 */
class Node extends AbstractEntity implements HierarchicalNodeInterface, \ArrayAccess
{
    /*
     * Import traits.
     */
    use HasTitle,
        HasWeight,
        HierarchicalNodeBehaviorTrait,
        SluggableBehaviorTrait,
        TimestampableBehaviorTrait,
        LoggableBehaviorTrait;

    /**
     * @var bool
     */
    private $slugDisableAutoGeneration;

    /**
     * @var Scribe\MantleBundle\Model\AuthorInterface
     */
    private $author;

    /**
     * @var NodeContextType
     */
    private $context;

    /**
     * @var ArrayCollection
     */
    private $revisions;

    /**
     * @var NodeRevision
     */
    private $latestRevision;

    /**
     * @var ArrayCollection
     */
    private $containerNodeRevisions;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        parent::__construct();

        $this->revisions              = new ArrayCollection();
        $this->containerNodeRevisions = new ArrayCollection();
    }

    /**
     * Support for casting from object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }



    /**
     * Returns the entity fields used to create the slug
     *
     * @return array
     */
    public function getAutoSlugFields()
    {
        return [ 'title' ];
    }

    /**
     * Set slugDisableAutoGeneration.
     *
     * @param bool $slugDisableAutoGeneration
     *
     * @return $this
     */
    public function setSlugDisableAutoGeneration($slugDisableAutoGeneration)
    {
        $this->slugDisableAutoGeneration = $slugDisableAutoGeneration;

        return $this;
    }

    /**
     * Get slugDisableAutoGeneration.
     *
     * @return bool
     */
    public function getSlugDisableAutoGeneration()
    {
        return (bool) $this->slugDisableAutoGeneration;
    }

    /**
     * Set author.
     *
     * @param \stdClass $author
     *
     * @return $this
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
     * Set context.
     *
     * @param NodeContextType $context
     *
     * @return $this
     */
    public function setContext(NodeContextType $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context.
     *
     * @return NodeContextType
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set revisions.
     *
     * @param ArrayCollection $revisions
     *
     * @return $this
     */
    public function setRevisions(ArrayCollection $revisions)
    {
        $this->revisions = $revisions;

        return $this;
    }

    /**
     * Get revisions.
     *
     * @return ArrayCollection
     */
    public function getRevisions()
    {
        return $this->revisions;
    }

    /**
     * Set latestRevision.
     *
     * @param NodeContextType $latestRevision
     *
     * @return $this
     */
    public function setLatestRevision(NodeContextType $latestRevision)
    {
        $this->latestRevision = $latestRevision;

        return $this;
    }

    /**
     * Get latestRevision.
     *
     * @return NodeContextType
     */
    public function getLatestRevision()
    {
        return $this->latestRevision;
    }

    /**
     * Check if it has latest node revision
     *
     * @return bool
     */
    public function hasLatestNodeRevision()
    {
        return (bool) ($this->latestRevision instanceof NodeRevision);
    }

    /**
     * Gets the value of containerNodeRevisions.
     *
     * @return ArrayCollection $containerNodeRevisions
     */
    public function getContainerNodeRevisions()
    {
        return $this->containerNodeRevisions;
    }

    /**
     * Sets the value of containerNodeRevisions.
     *
     * @param ArrayCollection $containerNodeRevisions
     *
     * @return $this
     */
    public function setContainerNodeRevisions(ArrayCollection $containerNodeRevisions)
    {
        $this->containerNodeRevisions = $containerNodeRevisions;

        return $this;
    }

    /**
     * Check if it has an collection of node revisions
     *
     * @return bool
     */
    public function hasContainerNodeRevisions()
    {
        return (bool) ($this->containerNodeRevisions->count() > 0);
    }

    /**
     * Recursively reassigns children in the event
     * a materialPath is modified.
     */
    protected function keepChildren()
    {
        foreach ($this->getChildNodes() as $child) {
            $child->setChildNodeOf($this);
            $child->keepChildren();
        }

        return $this;
    }

    /**
     * Sets node to a root.
     *
     * @return $this
     */
    public function setAsRoot()
    {
        $this->setMaterializedPath('/'.$this->getSlug());

        return $this;
    }
}

/* EOF */