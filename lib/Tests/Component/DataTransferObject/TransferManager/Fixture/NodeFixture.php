<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Component\DataTransferObject\TransferManager\Fixture;

/**
 * Class NodeFixture.
 */
class NodeFixture
{
    protected $revisions;
    protected $latestRevision;
    protected $containerNodeRevisions;
    protected $materializedPath;
    protected $the_author;
    protected $node_title;
    protected $node_weight;
    protected $createdOn;
    protected $updatedOn;

    public function setRevisions($revisions)
    {
        $this->revisions = $revisions;

        return $this;
    }

    public function setLatestRevision($latestRevision)
    {
        $this->latestRevision = $latestRevision;

        return $this;
    }

    public function setContainerNodeRevisions($containerNodeRevisions)
    {
        $this->containerNodeRevisions = $containerNodeRevisions;

        return $this;
    }

    public function setMaterializedPath($materializedPath)
    {
        $this->materializedPath = $materializedPath;

        return $this;
    }

    public function setAuthor($author)
    {
        $this->the_author = $author;

        return $this;
    }

    public function setTitle($title)
    {
        $this->node_title = $title;

        return $this;
    }

    public function setWeight($weight)
    {
        $this->node_weight = $weight;

        return $this;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }
}

/* EOF */
