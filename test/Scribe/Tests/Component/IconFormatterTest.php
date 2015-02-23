<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Component;

use PHPUnit_Framework_TestCase;
use Scribe\Tests\Component\Template\IconMocks;

use Scribe\SharedBundle\Entity\Icon as Icon;
use Scribe\SharedBundle\Component\IconFormatter;
use Scribe\Exception\BadFunctionCallException;
use Scribe\Exception\RuntimeException;

class IconFormatterTest extends PHPUnit_Framework_TestCase
{
    use IconMocks;

    public function setUp()
    {
        $this->mockIconEntities();
    }

    public function testFormatter()
    {
        $formatter = new IconFormatter($this->iconRepo, $this->iconFamilyRepo, $this->iconTemplateRepo); 
        $formatter->render('house', 'fa'); 
    }
}
