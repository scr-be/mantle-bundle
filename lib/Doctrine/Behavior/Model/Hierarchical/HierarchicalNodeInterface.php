<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 * (c) KnpLabs     <http://knplabs.com/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Model\Hierarchical;

use Doctrine\Common\Collections\Collection;

/**
 * Class HierarchicalNodeInterface.
 */
interface HierarchicalNodeInterface
{
    /**
     * @return string the id that will represent the node in the path
     **/
    public function getId();

    /**
     * @return string the materialized path,
     *                eg the representation of path from all ancestors
     **/
    public function getMaterializedPath();

    /**
     * @return string the real materialized path,
     *                eg the representation of path from all ancestors + current node
     **/
    public function getRealMaterializedPath();

    /**
     * @return string the materialized path from the parent, eg: the representation of path from all parent ancestors
     **/
    public function getParentMaterializedPath();

    /**
     * Set parent path.
     *
     * @param string $path the value to set.
     */
    public function setParentMaterializedPath($path);

    /**
     * @return HierarchicalNodeInterface the parent node
     **/
    public function getParentNode();

    /**
     * @param string $path the materialized path, eg: the the materialized path to its parent
     *
     * @return HierarchicalNodeInterface $this Fluent interface
     **/
    public function setMaterializedPath($path);

    /**
     * Used to build the hierarchical tree.
     * This method will do:
     *    - modify the parent of this node
     *    - Add the this node to the children of the new parent
     *    - Remove the this node from the children of the old parent
     *    - Modify the materialized path of this node and all its children, recursively.
     *
     * @param HierarchicalNodeInterface $node The node to use as a parent
     *
     * @return HierarchicalNodeInterface $this Fluent interface
     **/
    public function setChildNodeOf(HierarchicalNodeInterface $node);

    /**
     * @param HierarchicalNodeInterface $node the node to append to the children collection
     *
     * @return HierarchicalNodeInterface $this Fluent interface
     **/
    public function addChildNode(HierarchicalNodeInterface $node);

    /**
     * @return Collection the children collection
     **/
    public function getChildNodes();

    /**
     * @return bool if the node is a leaf (i.e has no children)
     **/
    public function isLeafNode();

    /**
     * @return bool if the node is a root (i.e has no parent)
     **/
    public function isRootNode();

    /**
     * Tells if this node is a child of another node.
     *
     * @param HierarchicalNodeInterface $node the node to compare with
     *
     * @return bool true if this node is a direct child of $node
     **/
    public function isChildNodeOf(HierarchicalNodeInterface $node);

    /**
     * @return int the level of this node, eg: the depth compared to root node
     **/
    public function getNodeLevel();

    /**
     * Builds a hierarchical tree from a flat collection of HierarchicalNodeInterface elements.
     **/
    public function buildTree(array $nodes);
}

/* EOF */
