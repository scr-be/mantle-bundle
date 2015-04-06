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

use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorHelperTrait;
use Scribe\Tests\Helper\AbstractMantleKernelUnitTestHelper;

/**
 * Class IconCreatorCachedTest.
 */
class IconCreatorCachedTest extends AbstractMantleKernelUnitTestHelper
{
    use IconCreatorMocksTrait;
    use IconCreatorHelperTrait;

    public function setUp()
    {
        parent::setUp();

        $this->mockIconEntities();
        $this->getNewHandlerChainWithAllHandlerTypes();
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
        $html      = $formatter->render('glass', 'fa');

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanRenderByAlias()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;

        $formatter = $this->getNewIconCreator(true);
        $html      = $formatter->render('glass-half-empty', 'fa');

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanCache()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;

        $formatter = $this->getNewIconCreator(true);
        $html      = $formatter->render('glass', 'fa');

        $this->assertTrue($formatter->getCacheHandlerChain()->has());
        $this->assertXmlStringEqualsXmlString($expected, $html);
        $this->assertXmlStringEqualsXmlString($expected, $formatter->getCacheHandlerChain()->get());
    }

    public function testCanCacheByAlias()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;

        $formatter = $this->getNewIconCreator(true);
        $html      = $formatter->render('glass-half-empty', 'fa');

        $this->assertTrue($formatter->getCacheHandlerChain()->has());
        $this->assertXmlStringEqualsXmlString($expected, $html);
        $this->assertXmlStringEqualsXmlString($expected, $formatter->getCacheHandlerChain()->get());
    }

    public function testCanAdvanced()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;
        $expected2 = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;
        $expected3 = '
            <span class="fa fa-5x fa-photo"
                  role="presentation"
                  aria-label="Icon: Photo (Category: Cat 1)">
            </span>
        ';

        $formatter = $this->getNewIconCreator(true);

        $html  = $formatter->render('glass', 'fa');
        $html2 = $formatter->setAriaHidden(false)->render('glass-half-empty', 'fa');
        $html3 = $formatter
            ->setAriaHidden(false)
            ->setFamily('fa')
            ->setStyles('fa-5x')
            ->render('photograph')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
        $this->assertXmlStringEqualsXmlString($expected2, $html2);
        $this->assertXmlStringEqualsXmlString($expected3, $html3);

        $formatter->render('glass', 'fa');
        $this->assertXmlStringEqualsXmlString($expected, $formatter->getCacheHandlerChain()->get());

        $formatter->setAriaHidden(false)->render('glass-half-empty', 'fa');
        $this->assertXmlStringEqualsXmlString($expected2, $formatter->getCacheHandlerChain()->get());

        $formatter
            ->setAriaHidden(false)
            ->setFamily('fa')
            ->setStyles('fa-5x')
            ->render('photograph')
        ;
        $this->assertXmlStringEqualsXmlString($expected3, $formatter->getCacheHandlerChain()->get());
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
                  ->setAriaRole('img');
        $html1 = $formatter->render();

        $formatter->setStyles('fa-lg', 'fa-fw')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole('img');
        $html2 = $formatter->render();

        $this->assertXmlStringNotEqualsXmlString($html1, $html2);
    }

    public function testShortFormWorksCorrectly()
    {
        $formatter = $this->getNewIconCreator(true);
        $html1 = $formatter->render('photo', 'fa', 'fa-basic', 'fa-lg', 'fa-fw');
        $html2 = $formatter->render('photo', 'fa', 'fa-basic', 'fa-lg', 'fa-fw');

        $this->assertXmlStringEqualsXmlString($html1, $html2);
    }

    public function testCanDetermineFamilyEntityLastMinute()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-label="Foo!">
            </span>
        ';

        $formatter = $this->getNewIconCreator(true);
        $formatter
            ->setAriaHidden(false)
            ->setAriaRole('img')
            ->setAriaLabel('Foo!')
            ->setFamily('fa')
            ->setStyles('fa-fw', 'fa-lg')
        ;
        $html = $formatter->render('glass');

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanGetCacheGeneratorAsService()
    {
        $formatter = $this->container->get('s.mantle.icon_creator');

        $this->assertInstanceOf('Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorCached', $formatter);
    }

    public function tearDown()
    {
        $this->clearFilesystemCache();

        parent::tearDown();
    }
}

/* EOF */
