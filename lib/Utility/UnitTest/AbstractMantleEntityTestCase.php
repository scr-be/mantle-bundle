<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\UnitTest;

use Doctrine\ORM\EntityManager;

/**
 * Class AbstractMantleEntityTestCase.
 *
 * Expands on our Kernel test case to provide helper functions for Doctrine's entity manager.
 */
abstract class AbstractMantleEntityTestCase extends AbstractMantleKernelTestCase
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * handle constructing the object instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setupEM();
    }

    /**
     * @return $this
     */
    private function setupEM()
    {
        $this->em = $this
            ->container
            ->get('doctrine')
            ->getManager()
        ;

        if (false === ($this->em instanceof EntityManager)) {
            throw new \RuntimeException('Unable to obtain a valid Doctrine EntityManager instance.');
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown()
    {
        $this
            ->em
            ->close()
        ;

        parent::tearDown();
    }
}
