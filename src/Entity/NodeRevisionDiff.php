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
use Scribe\Entity\AbstractEntity;

/**
 * NodeRevisionDiff
 * @package Scribe\MantleBundle\Entity
 */
class NodeRevisionDiff extends AbstractEntity
{
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
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Support for casting from object to string
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->getDiff(); 
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
