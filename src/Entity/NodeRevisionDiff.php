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
 * NodeRevisionDiff
 * @package Scribe\MantleBundle\Entity
 */
class NodeRevisionDiff
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $diff;

    /**
     * @var NodeRevision
     */
    private $nodeRevision;

    /**
     * perform any entity setup
     */
    public function __construct() {}

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
     * Set diff
     *
     * @param string $diff
     * @return NodeRevisionDiff
     */
    public function setDiff($diff)
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * Get diff
     *
     * @return string 
     */
    public function getDiff()
    {
        return $this->diff;
    }

    /**
     * Set nodeRevision
     *
     * @param \stdClass $nodeRevision
     * @return NodeRevisionDiff
     */
    public function setNodeRevision($nodeRevision)
    {
        $this->nodeRevision = $nodeRevision;

        return $this;
    }

    /**
     * Get nodeRevision
     *
     * @return \stdClass 
     */
    public function getNodeRevision()
    {
        return $this->nodeRevision;
    }
}
