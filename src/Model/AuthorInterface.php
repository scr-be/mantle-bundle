<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * interface AuthorInterface 
 *
 * @package Scribe\MantleBundle\Model
 */
interface AuthorInterface
{
    public function getNodeRevisions();
    public function setNodeRevisions(ArrayCollection $nodeRevisions);
    public function getNodes();
    public function setNodes(ArrayCollection $nodes);
}
