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
use Scribe\MantleBundle\Entity\AssetType;

/**
 * Class AssetTypeTest 
 */
class AssetTypeTest extends DefaultEntityTestHelper 
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
