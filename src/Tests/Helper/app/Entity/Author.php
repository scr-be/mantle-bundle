<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Fixtures\app\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Model\AuthorInterface;

class Author implements AuthorInterface
{
    /**
     * @var int
     */
    private $id = null;

    /**
     * @var ArrayCollection
     */
    private $revisions;

    /**
     * @var ArrayCollection
     */
    private $nodes;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNodeRevisions()
    {
    }
    public function setNodeRevisions(ArrayCollection $nodeRevisions)
    {
    }
    public function getNodes()
    {
    }
    public function setNodes(ArrayCollection $nodes)
    {
    }
}
