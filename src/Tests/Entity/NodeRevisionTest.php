<?php
/*
 * This file is part of the Scribe Mantle Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Entity;

use Scribe\Tests\Helper\MantleFrameworkEntityPhactoryHelper;

/**
 * Class NodeRevisionTest 
 */
class NodeRevisionTest extends MantleFrameworkEntityPhactoryHelper
{
    /**
     * @var string
     */
    private $repo;

    /**
     * @var string
     */
    private $nodeRevisions;

    /**
     * @var string
     */
    private $firstNodeRevision;

    public function setUp()
    {
        $this->repo = $this->container->get($this->config['nodeRevision']['service']); 
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodeRevisions($count);
        $this->nodeRevisions = $this->nodeRevisionRows();
        $this->firstNodeRevision = $this->nodeRevisionRows()[0];
    }

    public function testBasic()
    {
        $this->setupAndExercise(1);
    }
}
