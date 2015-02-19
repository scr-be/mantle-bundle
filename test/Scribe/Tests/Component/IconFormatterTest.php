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
use Scribe\SharedBundle\Entity\Icon as Icon;
use Scribe\SharedBundle\Component\IconFormatter;
use Scribe\Exception\BadFunctionCallException;
use Scribe\Exception\RuntimeException;

class IconFormatterTest extends PHPUnit_Framework_TestCase
{
    private $iconRepo;
    private $iconFamilyRepo;

    public function mockIcon()
    {
        $icon = $this->getMockBuilder('Scribe\SharedBundle\Entity\Icon')
                     ->getMock();
        $icon->method('getSlug')
             ->willReturn('house');
        $icon->method('getUnicode')
             ->willReturn('U+2014');
        $icon->method('getName')
             ->willReturn('House');
        $icon->method('getAliases')
             ->willReturn(['hus', 'abode', 'dwelling']);
        $icon->method('getAliases')
             ->willReturn(['Residential', 'Architectural']);
        $icon->method('getFamily')
             ->willReturn('font awesome');
        return $icon;
    }

    public function mockIconRepo($icon)
    {
        $iconRepo = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconRepository')
                         ->disableOriginalConstructor()
                         ->getMock();
        $iconRepo->method('findByName')
                 ->willReturn($icon);
        return $iconRepo;
    }

    public function mockIconFamily()
    {
        $iconFamily = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconFamily')
                           ->getMock();
        $iconFamily->method('getName')
                   ->willReturn('Font Awesome');
        $iconFamily->method('prefix')
                   ->willReturn('fa');
        return $iconFamily;
    }

    public function mockIconFamilyRepo($iconFamily)
    {
        $iconFamilyRepo = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconFamilyRepository')
                         ->disableOriginalConstructor()
                         ->getMock();
        $iconFamilyRepo->method('findByName')
                 ->willReturn($iconFamily);
        return $iconFamilyRepo;
    }

    public function mockIconTemplate()
    {
        $iconTemplate = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconTemplate')
                             ->getMock();
        $iconTemplate->method('getSlug')
                     ->willReturn('fa-italic');
        $iconTemplate->method('getDescription')
                     ->willReturn('renders icon as italic elements');
        $iconTemplate->method('getVariables')
                     ->willReturn(['size', 'name']);
        $iconTemplate->method('engine')
                     ->willReturn('twig');
        $iconTemplate->method('template')
                     ->willReturn('<i class="fa {{name}} {{size}}><i/>');
        return $iconTemplate;
    }

    public function mockIconEntities()
    {
        $icon = $this->mockIcon();
        $iconFamily = $this->mockIconFamily();
        $iconTemplate = $this->mockIconTemplate();
        $icon->method('getFamily')
                   ->willReturn($iconFamily);
        $iconFamily->method('getIcons')
                         ->willReturn([$icon]);
        $iconFamily->method('getTemplates')
                         ->willReturn([$iconTemplate]);
        $iconTemplate->method('getFamilies')
                           ->willReturn([$iconFamily]);
        $this->iconRepo = $this->mockIconRepo($icon);
        $this->iconFamilyRepo = $this->mockIconFamilyRepo($iconFamily);
    }

    public function setUp()
    {
        $this->mockIconEntities();
    }

    public function testFormatConstructor()
    {
        $formatter = new IconFormatter($this->iconRepo, $this->iconFamilyRepo); 
    }
}
