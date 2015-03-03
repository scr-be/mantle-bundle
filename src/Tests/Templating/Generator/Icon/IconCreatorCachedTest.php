<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Templating\Generator\Icon;

use MyProject\Proxies\__CG__\stdClass;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorHelperTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorCached;

/**
 * Class IconCreatorCacheddTest
 *
 * @package Scribe\MantleBundle\Tests\Templating\Generator\Icon
 */
class IconCreatorCachedTest extends PHPUnit_Framework_TestCase
{
    use IconCreatorMocksTrait;
    use IconCreatorHelperTrait;

    public function setUp()
    {
        $this->mockIconEntities();
        $this->getNewHandlerChainWithAllHandlerTypes();
    }

    public function testCanRender()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;

        $formatter = $this->getNewIconCreator(true);
        $html      = $formatter->render('glass', 'fa');

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanCache()
    {
        $formatter = $this->getNewIconCreator(true);
        $html      = $formatter->render('glass', 'fa');

        $this->assertTrue($formatter->getCacheHandlerChain()->has());
    }

    public function testDoesNotCacheIncorrectly()
    {
        $formatter = $this->getNewIconCreator(true);
        $formatter->setStyles('fa-lg')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole("img");
        $html1      = $formatter->render();

        $formatter->setStyles('fa-lg', 'fa-fw')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole("img");
        $html2      = $formatter->render();

        $this->assertXmlStringNotEqualsXmlString($html1, $html2);
    }

    private $container;

    protected function setupContainer()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    public function testCanGetCacheGeneratorAsService()
    {
        $this->setupContainer();
        $formatter = $this->container->get('s.mantle.iconcreator');

        $this->assertInstanceOf('Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorCached', $formatter);
    }

    protected function tearDown()
    {
        if (!$this->container instanceof ContainerInterface) {
            return;
        }

        $cacheDir = $this->container->getParameter('kernel.cache_dir');

        if (true === is_dir($cacheDir)) {
            $this->removeDirectoryRecursive($cacheDir);
        }
    }

    protected function removeDirectoryRecursive($path)
    {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectoryRecursive($file) : unlink($file);
        }

        rmdir($path);
    }
}

/* EOF */
