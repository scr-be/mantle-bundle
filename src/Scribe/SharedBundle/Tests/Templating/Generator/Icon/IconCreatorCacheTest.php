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
        $expected = $this->sanitizeHtml('
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

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
}

/* EOF */
