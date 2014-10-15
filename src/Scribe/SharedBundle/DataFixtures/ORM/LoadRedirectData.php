<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Scribe\SharedBundle\Fixture\AbstractYamlFixture;
use Scribe\SharedBundle\Entity\Redirects;

/**
 * LoadProjectSettingTypeData
 */
class LoadRedirectData extends AbstractYamlFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getFixtures('Redirects') as $i => $f) {
            $entity = new Redirects;
            $entity
                ->setPattern($f['pattern'])
                ->setDestination($f['destination'])
            ;

            $this->addReference('Redirects'.':'.$i, $entity);
            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10000;
    }
}
