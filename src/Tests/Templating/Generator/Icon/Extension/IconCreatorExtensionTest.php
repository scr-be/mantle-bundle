<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Templating\Generator\Icon\Extension;

use Twig_Environment;
use Scribe\MantleBundle\Templating\Generator\Icon\Extension\IconCreatorExtension;
use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorHelperTrait;

/**
 * Class IconCreatorExtensionTest.
 */
class IconCreatorExtensionTest extends AbstractMantleKernelTestCase
{
    use IconCreatorMocksTrait,
        IconCreatorHelperTrait;

    /**
     * @var IconCreatorExtension
     */
    protected $ext;

    /**
     * @var IconCreatorExtension
     */
    protected $extCached;

    /**
     * @var Twig_Environment
     */
    protected $twig;

    public function setUp()
    {
        parent::setUp();

        $this->twig = $this
            ->container
            ->get('twig')
        ;

        $this->mockIconEntities();
        $this->getNewHandlerChainWithAllHandlerTypes();
        $this->ext = new IconCreatorExtension($this->getNewIconCreatorNoEngine());
        $this->extCached = new IconCreatorExtension($this->getNewIconCreatorNoEngine(true));
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

        $html = $this->ext->getIconDeprecated($this->twig, 'glass', 'fa');

        static::assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanRenderCached()
    {
        $this->extCached->getIconCreator()->getCacheChain()->flushAll();

        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;

        $html1 = $this->extCached->getIconDeprecated($this->twig, 'glass', 'fa');
        static::assertXmlStringEqualsXmlString($expected, $html1);
        static::assertFalse($this->extCached->getIconCreator()->isCachedResult());

        $html2 = $this->extCached->getIconDeprecated($this->twig, 'glass', 'fa');
        static::assertXmlStringEqualsXmlString($expected, $html2);
        static::assertTrue($this->extCached->getIconCreator()->isCachedResult());
    }

    public function testCanRenderNew()
    {
        $extCached = static::$staticContainer->get('s.mantle.icon_creator.twig_extension');

        $expected = '
            <span class="fa fa-fw fa-user"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: User (Category: Web Application Icons)">
            </span>'
        ;

        $html1 = $extCached->getIcon($this->twig, 'user', 'fa', 'fa-fw');
        static::assertXmlStringEqualsXmlString($expected, $html1);

        $html2 = $extCached->getIcon($this->twig, 'user', 'fa', 'fa-fw');
        static::assertXmlStringEqualsXmlString($expected, $html2);
    }

    public function testCanRenderNewCached()
    {
        $extCached = static::$staticContainer->get('s.mantle.icon_creator.twig_extension');
        $extCached->getIconCreator()->getCacheChain()->flushAll();

        $expected = '
            <i class="material-icons md-info"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Swap Vertical Circle">swap_vertical_circle</i>'
        ;

        $html1 = $extCached->getIcon($this->twig, 'swap_vertical_circle', 'md', 'md-info');
        static::assertFalse($extCached->getIconCreator()->isCachedResult());
        static::assertXmlStringEqualsXmlString($expected, $html1);

        $html2 = $extCached->getIcon($this->twig, 'swap_vertical_circle', 'md', 'md-info');
        static::assertTrue($extCached->getIconCreator()->isCachedResult());
        static::assertXmlStringEqualsXmlString($expected, $html2);
    }
}
