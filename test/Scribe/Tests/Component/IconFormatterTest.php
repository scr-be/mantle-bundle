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
        $expected = <<<EOT
<span class="
  fa
  fa-glass">
</span>
EOT;
        $formatter = new IconFormatter($this->iconRepo, $this->iconFamilyRepo, $this->iconTemplateRepo); 
        $html = $formatter->render('fa', 'glass'); 
        $this->assertSame($html, $expected);
    }

    public function testFormatterAllowsFamilyPrefixOnName()
    {
        $expected = <<<EOT
<span class="
  fa
  fa-glass">
</span>
EOT;
        $formatter = new IconFormatter($this->iconRepo, $this->iconFamilyRepo, $this->iconTemplateRepo); 
        $html = $formatter->render('fa', 'fa-glass'); 
        $this->assertSame($html, $expected);
    }

    public function testFormatterCanAcceptOptionalClasses()
    {
        $expected = <<<EOT
<span class="
  fa
  fa-fw fa-lg
  fa-glass">
</span>
EOT;
        $formatter = new IconFormatter($this->iconRepo, $this->iconFamilyRepo, $this->iconTemplateRepo); 
        $html = $formatter->render('fa', 'glass', null, 'fa-fw', 'fa-lg'); 
        $this->assertSame($html, $expected);
    }

    /**
      * @expectedException Scribe\SharedBundle\Component\Exceptions\IconFormatterException 
      */
    public function testFormatterThrowsErrorGivenInvalidOptionalClasses()
    {
        $formatter = new IconFormatter($this->iconRepo, $this->iconFamilyRepo, $this->iconTemplateRepo); 
        $html = $formatter->render('fa', 'glass', null, 'fa-foo'); 
    }
}
