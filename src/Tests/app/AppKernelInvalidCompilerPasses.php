<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\app;

/**
 * Class AppKernelInvalidCompilerPasses.
 */
class AppKernelInvalidCompilerPasses extends \Scribe\WonkaBundle\Component\HttpKernel\Kernel
{
    /**
     * @return void
     */
    public function setup()
    {
        $this
            ->addBundle('\Symfony\Bundle\MonologBundle\MonologBundle')
            ->addBundle('\Symfony\Bundle\FrameworkBundle\FrameworkBundle')
            ->addBundle('\Symfony\Bundle\SecurityBundle\SecurityBundle')
            ->addBundle('\Symfony\Bundle\TwigBundle\TwigBundle')
            ->addBundle('\Doctrine\Bundle\DoctrineBundle\DoctrineBundle')
            ->addBundle('\Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle')
            ->addBundle('\Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle')
            ->addBundle('\Scribe\WonkaBundle\ScribeWonkaBundle')
            ->addBundle('\Scribe\MantleBundle\ScribeMantleBundle')
            ->addBundle('\Scribe\MantleBundle\Tests\ScribeMantleBadCompilerPassesBundle')
            ->addBundle('\Sensio\Bundle\DistributionBundle\SensioDistributionBundle', 'dev', 'test')
            ->addBundle('\Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle', 'dev', 'test')
            ->addBundle('\Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle', 'dev', 'test')
            ->addBundle('\Symfony\Bundle\DebugBundle\DebugBundle', 'dev', 'test')
            ->addBundle('\Scribe\SwimBundle\ScribeSwimBundle', 'dev', 'test')
            ->addBundle('\Scribe\CacheBundle\ScribeCacheBundle', 'dev', 'test');
    }
}

/* EOF */
