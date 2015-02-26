<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Tests\Templating\Generator\Icon;

use MyProject\Proxies\__CG__\stdClass;
use PHPUnit_Framework_TestCase;
use Scribe\SharedBundle\Templating\Generator\Icon\IconCreatorCache;

/**
 * Class IconCreatorCacheTest
 *
 * @package Scribe\SharedBundle\Tests\Templating\Generator\Icon
 */
class IconCreatorCacheTest extends PHPUnit_Framework_TestCase
{
    use IconMocks;

    public function setUp()
    {
        $this->mockIconEntities();
    }

    public function testCanRender()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass(true);
        $html      = $formatter->render('fa', 'glass');
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testCanCache()
    {
        $reflector = new \ReflectionClass('Scribe\SharedBundle\Templating\Generator\Icon\IconCreatorCache');

        $stateSetter = $reflector->getMethod('setCurrentState');
        $stateSetter->setAccessible(true);

        $cacheChecker = $reflector->getMethod('isCached');
        $cacheChecker->setAccessible(true);

        $formatter = $this->instantiateClass(true);
        $html      = $formatter->render('fa', 'glass');
        $html      = $this->sanitizeHtml($html);
        
        // ensure $formatter->isCached() returns false before we set new state
        $this->assertTrue(!$cacheChecker->invoke($formatter));

        $stateSetter->invoke($formatter, 'fa', 'glass', null);

        $this->assertTrue($cacheChecker->invoke($formatter));
    }

    public function testCanCachePresetValues()
    {
        $reflector = new \ReflectionClass('Scribe\SharedBundle\Templating\Generator\Icon\IconCreatorCache');

        $stateSetter = $reflector->getMethod('setCurrentState');
        $stateSetter->setAccessible(true);

        $cacheChecker = $reflector->getMethod('isCached');
        $cacheChecker->setAccessible(true);

        $formatter = $this->instantiateClass(true);
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

    public function testCanDoesNotCacheIncorrectly()
    {
        $formatter = $this->instantiateClass(true);
        $formatter->setStyles('fa-lg')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole("img");
        $html1      = $formatter->render();
        $html1      = $this->sanitizeHtml($html1);

        $formatter->setStyles('fa-lg', 'fa-fw')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole("img");
        $html2      = $formatter->render();
        $html2      = $this->sanitizeHtml($html2);

        $this->assertTrue($html1 != $html2);
    }
}

/* EOF */
