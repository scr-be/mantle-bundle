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

/**
 * Class NodeTest 
 */
class NodeTest extends DefaultEntityTestHelper 
{
    /**
     * @var Node 
     */
    private $node;

    public function testBasicSetup()
    {
        $this->makeNodes(1);
        $this->node = $this->nodeRows()[0];
    }
}
