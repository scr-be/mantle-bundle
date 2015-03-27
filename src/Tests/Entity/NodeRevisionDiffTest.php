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

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Scribe\MantleBundle\Tests\Helper\DefaultEntityTestHelper;
use Scribe\MantleBundle\Entity\NodeRevisionDiff;

/**
 * Class NodeRevisionDiffTest 
 */
class NodeRevisionDiffTest extends DefaultEntityTestHelper 
{
    /**
     * @var string
     */
    private $repo;

    /**
     * @var string
     */
    private $nodeRevisionDiffs;

    /**
     * @var string
     */
    private $firstNodeRevisionDiff;

    public function setUp()
    {
        $this->repo = $this->container->get($this->config['nodeRevisionDiff']['service']); 
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodeRevisionDiffs($count);
        $this->nodeRevisionDiffs = $this->nodeRevisionDiffRows();
        $this->firstNodeRevisionDiff = $this->nodeRevisionDiffRows()[0];
    }

    public function testBasic()
    {
        $this->setupAndExercise(1);
    }
}
