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
use Scribe\MantleBundle\Entity\Asset;
use Scribe\Tests\Helper\MantleFrameworkEntityPhactoryHelper;

/**
 * Class AssetTest 
 */
class AssetTest extends MantleFrameworkEntityPhactoryHelper
{
    /**
     * @var Asset 
     */
    private $firstAsset;

    /**
     * @var ArrayCollection 
     */
    private $assets;

    /**
     * @var string
     */
    private $repo;

    public function setUp()
    {
        $this->repo = $this->container->get($this->config['asset']['service']); 
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeAssets($count);
        $this->assets = $this->assetRows();
        $this->firstAsset = $this->assetRows()[0];
    }

    public function testBasic()
    {
        $this->setupAndExercise(1);
    }
}
