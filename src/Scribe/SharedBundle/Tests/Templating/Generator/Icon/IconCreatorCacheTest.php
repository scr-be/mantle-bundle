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

    public function testCanRender_ShortForm()
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
}

/* EOF */
