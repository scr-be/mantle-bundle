<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node;

use Scribe\Component\DependencyInjection\Container\ServiceFinder;
use Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;

/**
 * Interface NodeInterface.
 */
interface NodeCreatorInterface
{
    public function __construct(ServiceFinder $serviceFinder, NodeRepository $nodeRepository);
    public function render(Node $node, $args = []);
    public function renderFromSlug($slug, $args = []);
    public function renderFromMaterializedPath($slug, $args = []);
}

/* EOF */
