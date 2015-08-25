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
use Symfony\Component\Security\Core\User\User;

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
     * @var User
     */
    protected $author;

    /**
     * @var ArrayCollection
     */
    protected $revisions;

    /**
     * @var NodeRevision
     */
    protected $latestRevision;

    /**
     * @var ArrayCollection
     */
    protected $containerNodeRevisions;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        parent::__construct();

        $this->revisions = new ArrayCollection();
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
     * Returns the entity fields used to create the slug.
     *
     * @return array
     */
    public function getAutoSlugFields()
    {
        return ['title'];
    }

    /**
     * Set author.
     *
     * @param $author
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
     * @param NodeRevision $latestRevision
     *
     * @return $this
     */
    public function setLatestRevision(NodeRevision $latestRevision)
    {
        $this->latestRevision = $latestRevision;

        return $this;
    }

    /**
     * Get latestRevision.
     *
     * @return NodeRevision
     */
    public function getLatestRevision()
    {
        return $this->latestRevision;
    }

    /**
     * Check if it has latest node revision.
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
     * Check if it has an collection of node revisions.
     *
     * @return bool
     */
    public function hasContainerNodeRevisions()
    {
        return (bool) ($this->containerNodeRevisions->count() > 0);
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
