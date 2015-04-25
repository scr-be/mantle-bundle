<?php

/*
 * This file is part of the Scribe Mantle Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Doctrine\Entity\Asset;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Doctrine\Entity\Asset\AssetDescriptor;
use Scribe\Utility\UnitTest\AbstractMantlePhactoryTestCase;

/**
 * Class AssetDescriptorTest.
 */
class AssetDescriptorTest extends AbstractMantlePhactoryTestCase
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
        parent::setUp();

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
