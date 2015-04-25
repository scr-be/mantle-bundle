<?php

/*
 * This file is part of the Scribe Mantle Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Doctrine\Entity\Node;

use Scribe\Utility\UnitTest\AbstractMantlePhactoryTestCase;

/**
 * Class NodeRenderEngineTest.
 */
class NodeRenderEngine extends AbstractMantlePhactoryTestCase
{
    /**
     * @var string
     */
    private $repo;

    /**
     * @var string
     */
    private $nodeRenderEngines;

    /**
     * @var string
     */
    private $firstNodeRenderEngine;

    public function setUp()
    {
        parent::setUp();
        $this->repo = $this->container->get($this->config['nodeRenderEngine']['service']);
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodeRenderEngines($count);
        $this->nodeRenderEngines = $this->nodeRenderEngineRows();
        $this->firstNodeRenderEngine = $this->nodeRenderEngineRows()[0];
    }

    public function testBasic()
    {
        $this->setupAndExercise(1);
    }
}
