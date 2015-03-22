<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\DataFixtures\ORM;

use Scribe\MantleBundle\Fixture\AbstractYamlFixture;

/**
 * LoadIconFamilyData
 *
 * @package Scribe\MantleBundle\DataFixtures\ORM
 */
class LoadIconFamilyData extends AbstractYamlFixture
{
    /**
     * Init fixture
     */
    public function init()
    {
        $this
            ->setOrmFixtureName('IconFamily')
            ->loadOrmFixtureData()
        ;
    }
}

/* EOF */
