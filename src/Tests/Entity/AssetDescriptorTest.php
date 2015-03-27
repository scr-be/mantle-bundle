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
use Scribe\MantleBundle\Entity\AssetDescriptor;

/**
 * Class AssetDescriptorTest 
 */
class AssetDescriptorTest extends DefaultEntityTestHelper 
{
    /**
     * @var AssetDescriptor 
     */
    private $firstAssetDescriptor;

    /**
     * @var ArrayCollection 
     */
    private $assetDescriptors;

    /**
     * @var string
     */
    private $repo;

    public function setUp()
    {
        $this->repo = $this->container->get($this->config['assetDescriptor']['service']); 
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeAssetDescriptors($count);
        $this->assetDescriptors = $this->assetDescriptorRows();
        $this->firstAssetDescriptor = $this->assetDescriptorRows()[0];
    }

    public function testBasic()
    {
        $this->setupAndExercise(1);
    }
}
