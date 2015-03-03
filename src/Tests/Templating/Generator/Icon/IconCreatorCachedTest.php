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
        $html      = $formatter->render('fa', 'glass');

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanCache()
    {
        $reflector = new \ReflectionClass('Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorCached');

        $stateSetter = $reflector->getMethod('setCurrentState');
        $stateSetter->setAccessible(true);

        $cacheChecker = $reflector->getMethod('isCached');
        $cacheChecker->setAccessible(true);

        $formatter = $this->getNewIconCreator(true);
        $html      = $formatter->render('fa', 'glass');
        
        // ensure $formatter->isCached() returns false before we set new state
        $this->assertTrue(!$cacheChecker->invoke($formatter));

        $stateSetter->invoke($formatter, 'fa', 'glass', null);

        $this->assertTrue($cacheChecker->invoke($formatter));
    }

    public function testCanCachePresetValues()
    {
        $reflector = new \ReflectionClass('Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorCached');

        $stateSetter = $reflector->getMethod('setCurrentState');
        $stateSetter->setAccessible(true);

        $cacheChecker = $reflector->getMethod('isCached');
        $cacheChecker->setAccessible(true);

        $formatter = $this->getNewIconCreator(true);
        $formatter->setStyles('fa-lg')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole("img");
        $formatter->render();

        $this->assertTrue(!$cacheChecker->invoke($formatter));

        $formatter->setStyles('fa-lg')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole("img");
        
        $stateSetter->invoke($formatter, null, null, null);

        $this->assertTrue($cacheChecker->invoke($formatter));
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
        $formatter = $this->container->get('s.shared.iconcreator');
    }
}

/* EOF */
