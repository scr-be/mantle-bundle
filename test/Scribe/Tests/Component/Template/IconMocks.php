<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Component\Template;

/**
 * Class IconMocks
 *
 * @package Scribe\Test\Component\Template
 */
trait IconMocks
{
    private $iconRepo;
    private $iconFamilyRepo;
    
    public function mockIcon()
    {
        $icon = $this->getMock('Scribe\SharedBundle\Entity\Icon');
        $icon->method('getSlug')
             ->willReturn('house');
        $icon->method('getUnicode')
             ->willReturn('U+2014');
        $icon->method('getName')
             ->willReturn('House');
        $icon->method('getAliases')
             ->willReturn(['hus', 'abode', 'dwelling']);
        $icon->method('getCategories')
             ->willReturn(['Residential', 'Architectural']);
        return $icon;
    }

    public function mockIconRepo($icon)
    {
        $iconRepo = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconRepository')
                         ->setMethods(array('findOneByName'))
                         ->disableOriginalConstructor()
                         ->getMock();
        $iconRepo->method('findOneByName')
                 ->willReturn($icon);
        return $iconRepo;
    }

    public function mockIconFamily()
    {
        $iconFamily = $this->getMock('Scribe\SharedBundle\Entity\IconFamily');
        $iconFamily->method('getName')
                   ->willReturn('Font Awesome');
        $iconFamily->method('getPrefix')
                   ->willReturn('fa');
        return $iconFamily;
    }

    public function mockIconFamilyRepo($iconFamily)
    {
        $iconFamilyRepo = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconFamilyRepository')
                               ->setMethods(array('findOneByName'))
                               ->disableOriginalConstructor()
                               ->getMock();
        $iconFamilyRepo->method('findOneByName')
                       ->willReturn($iconFamily);
        return $iconFamilyRepo;
    }

    public function mockIconTemplate()
    {
        $iconTemplate = $this->getMock('Scribe\SharedBundle\Entity\IconTemplate');
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
}
