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
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Scribe\Entity\AbstractEntity;
use Scribe\EntityTrait\HasCreatedOn;
use Scribe\EntityTrait\HasUpdatedOn;
use Scribe\EntityTrait\HasSlug;
use Scribe\EntityTrait\HasTitle;
use Scribe\EntityTrait\HasWeight;

/**
 * Node
 * @package Scribe\MantleBundle\Entity
 */
class Node extends AbstractEntity implements ORMBehaviors\Tree\NodeInterface, \ArrayAccess
{
    /**
     * import traits
     */
    use ORMBehaviors\Tree\Node,
        HasCreatedOn,
        HasUpdatedOn,
        HasSlug,
        HasTitle,
        HasWeight;

    /**
     * @var boolean
     */
    private $locked;

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
     * perform any entity setup
     */
    public function __construct()
    {
        parent::__construct();

        $this->revisions              = new ArrayCollection;
        $this->containerNodeRevisions = new ArrayCollection;
    }

    /**
     * Support for casting from object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();        
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     * @return Node
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean 
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     * @return Node
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
     * Set context
     *
     * @param \stdClass $context
     * @return Node
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context
     *
     * @return \stdClass 
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set revisions
     *
     * @param \stdClass $revisions
     * @return Node
     */
    public function setRevisions($revisions)
    {
        $this->revisions = $revisions;

        return $this;
    }

    /**
     * Get revisions
     *
     * @return \stdClass 
     */
    public function getRevisions()
    {
        return $this->revisions;
    }

    /**
     * Set latestRevision
     *
     * @param \stdClass $latestRevision
     * @return Node
     */
    public function setLatestRevision($latestRevision)
    {
        $this->latestRevision = $latestRevision;

        return $this;
    }

    /**
     * Get latestRevision
     *
     * @return \stdClass 
     */
    public function getLatestRevision()
    {
        return $this->latestRevision;
    }

    /**
     * Gets the value of containerNodeRevisions
     *
     * @return $containerNodeRevisions
     */
    public function getContainerNodeRevisions()
    {
        return $this->containerNodeRevisions;
    }

    /**
     * Sets the value of containerNodeRevisions
     *
     * @param ArrayCollection
     *
     * @return $this
     */
    public function setContainerNodeRevisions(ArrayCollection $containerNodeRevisions)
    {
        $this->containerNodeRevisions = $containerNodeRevisions;

        return $this;
    }

    /**
     * Recursively reassigns children in the event
     * a materialPath is modified
     *
     * @return void
     */
    protected function keepChildren()
    {
        foreach($this->getChildNodes() as $child) {
            $child->setChildNodeOf($this);
            $child->keepChildren();
        } 

        return $this;
    }

    /**
     * Sets node to a root 
     *
     * @return $this 
     */
    public function setAsRoot()
    {
        $this->setMaterializedPath('/'. $this->getSlug());
        $this->keepChildren();

        return $this;
    }
}
