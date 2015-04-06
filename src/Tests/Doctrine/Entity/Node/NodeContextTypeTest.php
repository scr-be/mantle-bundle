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
 * Class NodeContextTypeTest.
 */
class NodeContextTypeTest extends AbstractMantlePhactoryTestCase
{
    /**
     * @var string
     */
    private $repo;

    /**
     * @var string
     */
    private $nodeContextTypes;

    /**
     * @var string
     */
    private $firstNodeContextType;

    public function setUp()
    {
        $this->repo = $this->container->get($this->config['nodeContextType']['service']);
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodeContextTypes($count);
        $this->nodeContextTypes = $this->nodeContextTypeRows();
        $this->firstNodeContextType = $this->nodeContextTypeRows()[0];
    }

    public function testBasic()
    {
        $this->setupAndExercise(1);
    }
}
