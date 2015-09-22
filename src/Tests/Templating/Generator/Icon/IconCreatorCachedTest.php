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
use Scribe\WonkaBundle\Utility\TestCase\KernelTestCase;

/**
 * Class IconCreatorCachedTest.
 */
class IconCreatorCachedTest extends KernelTestCase
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
        $html = $formatter->render('glass', 'fa');

        static::assertXmlStringEqualsXmlString($expected, $html);
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
        $html = $formatter->render('glass-half-empty', 'fa');

        static::assertXmlStringEqualsXmlString($expected, $html);
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
        $html = $formatter->render('glass', 'fa');

        static::assertTrue($formatter->getCacheChain()->has());
        static::assertXmlStringEqualsXmlString($expected, $html);
        static::assertXmlStringEqualsXmlString($expected, $formatter->getCacheChain()->get());
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
        $html = $formatter->render('glass-half-empty', 'fa');
        static::assertFalse($formatter->isCachedResult());

        static::assertTrue($formatter->getCacheChain()->has());
        static::assertXmlStringEqualsXmlString($expected, $html);

        $html = $formatter->render('glass-half-empty', 'fa');
        static::assertTrue($formatter->isCachedResult());

        static::assertXmlStringEqualsXmlString($expected, $html);
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

        $html = $formatter->render('glass', 'fa');
        static::assertFalse($formatter->isCachedResult());
        $html2 = $formatter->setAriaHidden(false)->render('glass-half-empty', 'fa');
        static::assertFalse($formatter->isCachedResult());
        $html3 = $formatter
            ->setAriaHidden(false)
            ->setFamily('fa')
            ->setStyles('fa-5x')
            ->render('photograph')
        ;
        static::assertFalse($formatter->isCachedResult());

        static::assertXmlStringEqualsXmlString($expected, $html);
        static::assertXmlStringEqualsXmlString($expected2, $html2);
        static::assertXmlStringEqualsXmlString($expected3, $html3);

        $formatter->render('fa-glass');
        static::assertFalse($formatter->isCachedResult());
        static::assertXmlStringEqualsXmlString($expected, $formatter->getCacheChain()->get());
        $formatter->render('fa-glass');
        static::assertTrue($formatter->isCachedResult());

        $formatter->setAriaHidden(false)->render('glass-half-empty', 'fa');
        static::assertXmlStringEqualsXmlString($expected2, $formatter->getCacheChain()->get());

        $formatter
            ->setAriaHidden(false)
            ->setFamily('fa')
            ->setStyles('fa-5x')
            ->render('photograph')
        ;
        static::assertXmlStringEqualsXmlString($expected3, $formatter->getCacheChain()->get());
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
        static::assertFalse($formatter->isCachedResult());

        $formatter->setStyles('fa-lg', 'fa-fw')
                  ->setFamily('fa')
                  ->setIcon('glass')
                  ->setTemplate('fa-basic')
                  ->setAriaHidden(true)
                  ->setAriaLabel('Glass!')
                  ->setAriaRole('img');
        $html2 = $formatter->render();

        static::assertFalse($formatter->isCachedResult());
        static::assertXmlStringNotEqualsXmlString($html1, $html2);
    }

    public function testShortFormWorksCorrectly()
    {
        $formatter = $this->getNewIconCreator(true);
        $html1 = $formatter->setTemplate('fa-basic')->render('photo', 'fa', 'fa-lg', 'fa-fw');
        static::assertFalse($formatter->isCachedResult());

        $html2 = $formatter->setTemplate('fa-basic')->render('photo', 'fa', 'fa-lg', 'fa-fw');
        static::assertTrue($formatter->isCachedResult());

        static::assertXmlStringEqualsXmlString($html1, $html2);
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

        static::assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanGetCacheGeneratorAsService()
    {
        $formatter = $this->container->get('s.mantle.icon_creator');

        static::assertInstanceOf('Scribe\MantleBundle\Templating\Generator\Icon\IconCreatorCached', $formatter);
    }

    public function tearDown()
    {
        $this->clearFilesystemCache();

        parent::tearDown();
    }
}

/* EOF */
