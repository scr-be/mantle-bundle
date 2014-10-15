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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Scribe\SharedBundle\Entity\ResponseSearchReplace;

/**
 * LoadResponseSearchReplaceData
 * doctrine fixture to load data using its respective entity
 */
class LoadResponseSearchReplaceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $pairs = [
            //'David Alan Rech' => '<a href="http://davidalanrech.com/">David Alan Rech</a>',
        ];

        foreach ($pairs as $k => $v) {
            $rsr = new ResponseSearchReplace();
            $rsr
                ->setK($k)
                ->setV($v)
                ->setRe(false)
            ;
            $manager->persist($rsr);
        }

        $rePairs = [
            'Well[ -]Formed Document' => 'Well Formed Document',
        ];

        foreach ($rePairs as $k => $v) {
            $rsr = new ResponseSearchReplace();
            $rsr
                ->setK($k)
                ->setV($v)
                ->setRe(true)
            ;
            $manager->persist($rsr);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1000;
    }
}
