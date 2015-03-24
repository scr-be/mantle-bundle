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
 * Node
 * @package Scribe\MantleBundle\Entity
 */
class Node
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $locked;

    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @var \DateTime
     */
    private $updatedOn;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $weight;

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
        $this->revisions              = new ArrayCollection;
        $this->containerNodeRevisions = new ArrayCollection;
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return Node
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
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     * @return Node
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime 
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Node
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
     * Set title
     *
     * @param string $title
     * @return Node
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Node
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
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
}
