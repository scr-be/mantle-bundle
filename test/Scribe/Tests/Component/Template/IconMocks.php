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
    private $iconTemplateRepo;
    
    public function mockIcon()
    {
        $icon = $this->getMock('Scribe\SharedBundle\Entity\Icon');
        $icon->method('getSlug')
             ->willReturn('glass');
        $icon->method('getUnicode')
             ->willReturn('f000');
        $icon->method('getName')
             ->willReturn('Glass');
        $icon->method('getAliases')
             ->willReturn(null);
        $icon->method('getCategories')
             ->willReturn(['Web Application Icons']);
        $icon->method('hasCategories')
             ->willReturn(true);
        return $icon;
    }

    public function mockIconRepo($icon)
    {
        $iconRepo = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconRepository')
                         ->setMethods(array('findOneBySlug'))
                         ->disableOriginalConstructor()
                         ->getMock();
        $iconRepo->method('findOneBySlug')
                 ->with($icon->getSlug())
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
        $iconFamily->method('getSlug')
                   ->willReturn('fa');
        $iconFamily->method('getRequiredClasses')
                   ->willReturn(array('fa'));
        $iconFamily->method('getRequiredClassesFormatted')
                   ->willReturn('fa');
        $iconFamily->method('getOptionalClasses')
                   ->willReturn(array('fa-fw', 'fa-lg', 'fa-2x'));
        $iconFamily->method('hasOptionalClasses')
                   ->willReturn(true);
        return $iconFamily;
    }

    public function mockIconFamilyRepo($iconFamily)
    {
        $iconFamilyRepo = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconFamilyRepository')
                               ->setMethods(array('findOneBySlug'))
                               ->disableOriginalConstructor()
                               ->getMock();
        $iconFamilyRepo->method('findOneBySlug')
                       ->willReturn($iconFamily);
        return $iconFamilyRepo;
    }

    public function mockIconTemplate()
    {
        $iconTemplate = $this->getMock('Scribe\SharedBundle\Entity\IconTemplate');
        $iconTemplate->method('getSlug')
                     ->willReturn('fa-basic');
        $iconTemplate->method('getDescription')
                     ->willReturn('Basic Font Awesome markup using span html tag.');
        $iconTemplate->method('getEngine')
                     ->willReturn('twig');
        $template = <<<EOT
<span class="{{ family.getRequiredClasses()|join(' ') }}{% if styles %} {{ styles|join(' ') }}{% endif %} {{ family.getPrefix() }}-{{ icon.getSlug() }}"
      aria-hidden="{% if helper.isPresentationOnly %}true{% else %}false{% endif %}"
      aria-label="{% if helper.hasAccessibilityText %}{{ helper.getAccessibilityText }}{% else %}Icon: {{ icon.getName }}{% if icon.hasCategories %} (Category: {{ icon.getCategories[0] }}){% endif %}{% endif %}">
</span>
EOT;
        $iconTemplate->method('getTemplate')
          ->willReturn($template);
        return $iconTemplate;
    }

    public function mockIconTemplateRepo($iconTemplate)
    {
        $iconTemplateRepo = $this->getMockBuilder('Scribe\SharedBundle\Entity\IconTemplateRepository')
                               ->setMethods(array('findOneBySlug'))
                               ->disableOriginalConstructor()
                               ->getMock();
        $iconTemplateRepo->method('findOneBySlug')
                         ->willReturn($iconTemplate);
        return $iconTemplateRepo;
    }

    public function mockIconEntities()
    {
        $icon = $this->mockIcon();
        $iconFamily = $this->mockIconFamily();
        $iconTemplate = $this->mockIconTemplate();
        $icon->method('getFamilies')
             ->willReturn([$iconFamily]);
        $iconFamily->method('getIcons')
                   ->willReturn([$icon]);
        $iconFamily->method('getTemplates')
                   ->willReturn([$iconTemplate]);
        $iconTemplate->method('getFamilies')
                     ->willReturn([$iconFamily]);
        $this->iconRepo = $this->mockIconRepo($icon);
        $this->iconFamilyRepo = $this->mockIconFamilyRepo($iconFamily);
        $this->iconTemplateRepo = $this->mockIconTemplateRepo($iconTemplate);
    }
}
