<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * Class AppKernel.
 */
class AppKernel extends \Scribe\WonkaBundle\Component\HttpKernel\Kernel
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
            ->addBundle('\Scribe\Teavee\ObjectCacheBundle\ScribeTeaveeObjectCacheBundle')
            ->addBundle('\Scribe\Teavee\ScribbleDownBundle\ScribeTeaveeScribbleDownBundle')
            ->addBundle('\Scribe\Teavee\HtmlGeneratorBundle\ScribeTeaveeHtmlGeneratorBundle')
            ->addBundle('\Symfony\Bundle\DebugBundle\DebugBundle', 'dev', 'test')
            ->addBundle('\Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle', 'dev', 'test')
            ->addBundle('\Scribe\Arthur\DoctrineFixturesBundle\ScribeArthurDoctrineFixturesBundle', 'dev', 'test')
            ->addBundle('\Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle', 'dev', 'test')
            ->addBundle('\Sensio\Bundle\DistributionBundle\SensioDistributionBundle', 'dev', 'test')
            ->addBundle('\Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle', 'dev', 'test');
    }
}
