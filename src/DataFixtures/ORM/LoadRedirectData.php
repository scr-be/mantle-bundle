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

use Doctrine\Common\Persistence\ObjectManager;
use Scribe\MantleBundle\Fixture\AbstractYamlFixture;
use Scribe\MantleBundle\Entity\Redirects;

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

/* EOF */
