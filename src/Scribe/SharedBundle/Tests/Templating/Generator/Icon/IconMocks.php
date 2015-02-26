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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\SharedBundle\Templating\Generator\Icon\IconCreator;

/**
 * Class IconMocks
 *
 * @package Scribe\SharedBundle\Tests\Templating\Generator\Icon
 */
trait IconMocks
{
    private $iconFamilyRepo;

    private $engine;

    protected function mockIcon_Glass()
    {
        $icon = $this->getMock('Scribe\SharedBundle\Entity\Icon');
        $icon
            ->method('getSlug')
            ->willReturn('glass')
        ;
        $icon
            ->method('getUnicode')
            ->willReturn('f000')
        ;
        $icon
            ->method('getName')
            ->willReturn('Glass')
        ;
        $icon
            ->method('getAliases')
            ->willReturn(null)
        ;
        $icon
            ->method('getCategories')
            ->willReturn(['Web Application Icons'])
        ;
        $icon
            ->method('hasCategories')
            ->willReturn(true)
        ;

        return $icon;
    }

    protected function mockIcon_Photo()
    {
        $icon = $this->getMock('Scribe\SharedBundle\Entity\Icon');
        $icon
            ->method('getSlug')
            ->willReturn('photo')
        ;
        $icon
            ->method('getUnicode')
            ->willReturn('f111')
        ;
        $icon
            ->method('getName')
            ->willReturn('Photo')
        ;
        $icon
            ->method('getAliases')
            ->willReturn(['Photograph'])
        ;
        $icon
            ->method('getCategories')
            ->willReturn(['Cat 1', 'Cat 2'])
        ;
        $icon
            ->method('hasCategories')
            ->willReturn(true)
        ;

        return $icon;
    }

    protected function mockIconFamily()
    {
        $iconFamily = $this->getMock('Scribe\SharedBundle\Entity\IconFamily');
        $iconFamily
            ->method('getName')
            ->willReturn('Font Awesome')
        ;
        $iconFamily
            ->method('getPrefix')
            ->willReturn('fa')
        ;
        $iconFamily
            ->method('getSlug')
            ->willReturn('fa')
        ;
        $iconFamily
            ->method('getRequiredClasses')
            ->willReturn(['fa'])
        ;
        $iconFamily
            ->method('getRequiredClassesFormatted')
            ->willReturn('fa')
        ;
        $iconFamily
            ->method('getOptionalClasses')
            ->willReturn(['fa-fw', 'fa-lg', 'fa-2x', 'fa-5x'])
        ;
        $iconFamily
            ->method('hasOptionalClasses')
            ->willReturn(true)
        ;

        return $iconFamily;
    }

    protected function mockIconFamilyRepo($iconFamily)
    {
        $iconFamilyRepo = $this
            ->getMockBuilder('Scribe\SharedBundle\EntityRepository\IconFamilyRepository')
            ->setMethods(['findOneBySlug', 'loadIconFamilyBySlug'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $iconFamilyRepo
            ->method('findOneBySlug')
            ->willReturn($iconFamily)
        ;
        $iconFamilyRepo
            ->method('loadIconFamilyBySlug')
            ->willReturn($iconFamily)
        ;

        return $iconFamilyRepo;
    }

    protected function mockIconFamilyRepoNoFamilyResult($iconFamily)
    {
        $iconFamilyRepo = $this
            ->getMockBuilder('Scribe\SharedBundle\EntityRepository\IconFamilyRepository')
            ->setMethods(['findOneBySlug', 'loadIconFamilyBySlug'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $iconFamilyRepo
            ->method('findOneBySlug')
            ->will($this->throwException(new \Doctrine\ORM\ORMException));
        ;
        $iconFamilyRepo
            ->method('loadIconFamilyBySlug')
            ->will($this->throwException(new \Doctrine\ORM\ORMException));
        ;

        return $iconFamilyRepo;
    }

    protected function mockIconTemplate1()
    {
        $iconTemplate = $this->getMock('Scribe\SharedBundle\Entity\IconTemplate');
        $iconTemplate
            ->method('getSlug')
            ->willReturn('fa-basic')
        ;
        $iconTemplate
            ->method('getDescription')
            ->willReturn('Basic Font Awesome markup using span html tag.')
        ;
        $iconTemplate
            ->method('getEngine')
            ->willReturn('twig')
        ;
        $template = <<<EOT
<span class="{{ family.getRequiredClasses()|join(' ') }} {% if styles %}{{ styles|join(' ') }}{% endif %} {{ family.getPrefix() }}-{{ icon.getSlug() }}"
      {% if helper.hasAriaRole %}role="{{ helper.getAriaRole }}"{% endif %}
      {% if helper.isAriaHidden %}aria-hidden="true"{% endif %}
      aria-label="{% if helper.hasAriaLabel %}{{ helper.getAriaLabel }}{% else %}Icon: {{ icon.getName }}{% if icon.hasCategories %} (Category: {{ icon.getCategories[0] }}){% endif %}{% endif %}">
</span>
EOT;
        $iconTemplate
            ->method('getTemplate')
            ->willReturn($template)
        ;

        return $iconTemplate;
    }

    protected function mockIconTemplate2()
    {
        $iconTemplate = $this->getMock('Scribe\SharedBundle\Entity\IconTemplate');
        $iconTemplate
            ->method('getSlug')
            ->willReturn('fa-different')
        ;
        $iconTemplate
            ->method('getDescription')
            ->willReturn('Different Font Awesome markup using div html tag and different parameter ordering.')
        ;
        $iconTemplate
            ->method('getEngine')
            ->willReturn('twig')
        ;
        $template = <<<EOT
<div {% if helper.hasAriaRole %}role="{{ helper.getAriaRole }}"{% endif %}
     class="{{ family.getRequiredClasses()|join(' ') }} {% if styles %}{{ styles|join(' ') }}{% endif %} {{ family.getPrefix() }}-{{ icon.getSlug() }}"
     {% if helper.hasAriaRole %}role="{{ helper.getAriaRole }}"{% endif %}
     {% if helper.isAriaHidden %}aria-hidden="true"{% endif %}
     {% if helper.hasAriaLabel %}aria-label="{{ helper.getAriaLabel }}"{% endif %}>
</div>
EOT;
        $iconTemplate
            ->method('getTemplate')
            ->willReturn($template)
        ;

        return $iconTemplate;
    }

    protected function mockEngineInterface()
    {
        $twigEnv                      = new \Twig_Environment(new \Twig_Loader_String());
        $templateNamedParserInterface = $this->getMock('Symfony\Component\Templating\TemplateNameParserInterface');
        $templating                   = new \Symfony\Bridge\Twig\TwigEngine($twigEnv, $templateNamedParserInterface);

        return $templating;
    }

    protected function mockIconEntities()
    {
        $iconFamily    = $this->mockIconFamily();
        $iconGlass     = $this->mockIcon_Glass();
        $iconPhoto     = $this->mockIcon_Photo();
        $iconTemplate1 = $this->mockIconTemplate1();
        $iconTemplate2 = $this->mockIconTemplate2();

        $iconGlass
            ->method('getFamilies')
            ->willReturn(new ArrayCollection([$iconFamily]))
        ;
        $iconPhoto
            ->method('getFamilies')
            ->willReturn(new ArrayCollection([$iconFamily]))
        ;
        $iconFamily
            ->method('getIcons')
            ->willReturn(new ArrayCollection([$iconGlass, $iconPhoto]))
        ;
        $iconFamily
            ->method('getTemplates')
            ->willReturn(new ArrayCollection([$iconTemplate1, $iconTemplate2]))
        ;
        $iconTemplate1
            ->method('getFamilies')
            ->willReturn(new ArrayCollection([$iconFamily]))
        ;
        $iconTemplate2
            ->method('getFamilies')
            ->willReturn(new ArrayCollection([$iconFamily]))
        ;

        $this->iconFamilyRepo               = $this->mockIconFamilyRepo($iconFamily);
        $this->iconFamilyRepoNoFamilyResult = $this->mockIconFamilyRepoNoFamilyResult($iconFamily);
        $this->engine                       = $this->mockEngineInterface();
    }

    protected function instantiateClass()
    {
        return new IconCreator($this->iconFamilyRepo, $this->engine);
    }

    protected function sanitizeHtml($html)
    {
        $config = [
            'clean'          => true,
            'output-xhtml'   => true,
            'show-body-only' => true,
            'wrap'           => 0,
        ];

        $tidy = new \Tidy;
        $tidy->parseString($html, $config, 'utf8');
        $tidy->cleanRepair();

        return (string) $tidy;
    }

    protected function getReflectionOfIconCreatorForMethod($method)
    {
        $refFormat = new \ReflectionClass('Scribe\SharedBundle\Templating\Generator\Icon\IconCreator');
        $method = $refFormat->getMethod($method);
        $method->setAccessible(true);

        return [
            $this->instantiateClass(),
            $method
        ];
    }
}

/* EOF */