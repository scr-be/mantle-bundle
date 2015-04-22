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
        $this->ext       = new IconCreatorExtension($this->getNewIconCreatorNoEngine());
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

        $html = $this->ext->getIcon($this->twig, 'glass', 'fa');

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testCanRenderCached()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        ;

        $html1 = $this->extCached->getIcon($this->twig, 'glass', 'fa');
        $html2 = $this->extCached->getIcon($this->twig, 'glass', 'fa');

        $this->assertXmlStringEqualsXmlString($expected, $html1);
        $this->assertXmlStringEqualsXmlString($expected, $html2);
    }

    public function tearDown()
    {
        $this->clearFilesystemCache();

        parent::tearDown();
    }
}
