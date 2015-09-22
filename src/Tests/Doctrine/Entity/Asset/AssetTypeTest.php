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
use Scribe\MantleBundle\Doctrine\Entity\Asset\AssetType;
use Scribe\WonkaBundle\Utility\TestCase\PhactoryTestCase;

/**
 * Class AssetTypeTest.
 */
class AssetTypeTest extends PhactoryTestCase
{
    /**
     * @var AssetType
     */
    private $firstAssetType;

    /**
     * @var ArrayCollection
     */
    private $assetTypes;

    /**
     * @var string
     */
    private $repo;

    public function setUp()
    {
        parent::setUp();

        $this->repo = $this->container->get($this->config['assetType']['service']);
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeAssetTypes($count);
        $this->assetTypes = $this->assetTypeRows();
        $this->firstAssetType = $this->assetTypeRows()[0];
    }

    public function testBasic()
    {
        $this->setupAndExercise(1);
    }
}
