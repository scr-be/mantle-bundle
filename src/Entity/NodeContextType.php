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
use Scribe\Doctrine\Base\Model\HasSlug;
use Scribe\Doctrine\Base\Model\HasName;

/**
 * NodeContextType.
 */
class NodeContextType extends AbstractEntity
{
    /*
     * import traits
     */
    use HasSlug,
        HasName;

    /**
     * @var ArrayCollection
     */
    private $nodes;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        parent::__construct();

        $this->nodes = new ArrayCollection();
    }

    /**
     * Support for casting from object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set nodes.
     *
     * @param \stdClass $nodes
     *
     * @return NodeContextType
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * Get nodes.
     *
     * @return \stdClass
     */
    public function getNodes()
    {
        return $this->nodes;
    }
}
