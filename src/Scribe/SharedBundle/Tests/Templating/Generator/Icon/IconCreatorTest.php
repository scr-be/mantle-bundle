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

use MyProject\Proxies\__CG__\stdClass;
use PHPUnit_Framework_TestCase;
use Scribe\SharedBundle\Templating\Generator\Icon\IconCreator;

/**
 * Class IconCreatorTest
 *
 * @package Scribe\SharedBundle\Tests\Templating\Generator\Icon
 */
class IconCreatorTest extends PHPUnit_Framework_TestCase
{
    use IconMocks;

    public function setUp()
    {
        $this->mockIconEntities();
    }

    public function testCanRender_ShortForm()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter->render('fa', 'glass');
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testCanRender_LongForm()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setFamily('fa')
            ->setIcon('glass')
            ->render()
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setIcon('glass')
            ->setFamily('fa')
            ->render()
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testAcceptsPrefixedAndNonPrefixIconSlug_ShortForm()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter->render('fa', 'fa-glass');
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);

        $formatter = $this->instantiateClass();
        $html      = $formatter->render('fa', 'glass');
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testAcceptsPrefixedAndNonPrefixIconSlug_LongForm()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setFamily('fa')
            ->setIcon('fa-glass')
            ->render()
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setFamily('fa')
            ->setIcon('glass')
            ->render()
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testSupportForOptionalStyles_ShortForm()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter->render('fa', 'glass', null, 'fa-fw', 'fa-lg');
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testSupportForOptionalStyles_LongForm()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setStyles('fa-fw', 'fa-lg')
            ->render('fa', 'glass');
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testSupportForOptionalStylesOverwrittenByRender_LongForm()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-5x fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setStyles('fa-fw', 'fa-lg')
            ->render('fa', 'glass', null, 'fa-5x');
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    /**
      * @expectedException        Scribe\SharedBundle\Templating\Generator\Icon\IconException
      * @expectedExceptionMessage The requested optional style fa-foo is not compatible with the Font Awesome font family.
      * @expectedExceptionCode    51
      */
    public function testThrowsExceptionOnInvalidOptionalStyles_ShortForm()
    {
        $formatter = $this->instantiateClass();
        $html      = $formatter->render('fa', 'glass', null, 'fa-foo');
    }

    /**
     * @expectedException        Scribe\SharedBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage The requested optional style fa-bad-style is not compatible with the Font Awesome font family.
     * @expectedExceptionCode    51
     */
    public function testThrowsExceptionOnInvalidOptionalStyles_LongForm()
    {
        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-bad-style')
            ->render()
        ;
    }

    public function testAriaHiddenPropertyCanBeDisabled()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaHidden(false)
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testAriaLabelCanBeSetExplicitly()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label=Glass is half full!">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaLabel("Glass is half full!")
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testAriaRoleCanBeSetExplicitly()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-hidden="true"
                  aria-label=Glass is half full!">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaRole("img")
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    /**
     * @expectedException             Scribe\SharedBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessageRegex #You attempted to set an invalid aria role attribute. Valid values:.*#
     * @expectedExceptionCode         50
     */
    public function testThrowsExceptionOnInvalidAriaRoleValue()
    {
        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaRole("does-not-exists")
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;
        $html      = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testSettingTemplate_Long()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $formatter->setFamily('fa')
                  ->setIcon('glass')
                  ->setStyles('fa-fw', 'fa-lg')
                  ->setTemplate('fa-basic');
        $html = $formatter->render();
        $html = $this->sanitizeHtml($html);
        $this->assertSame($html, $expected);
    }

    public function testOtherIconInFamilyCanBeAccessed()
    {
        $expected  = $this->sanitizeHtml('
            <span class="fa fa-5x fa-photo"
                  role="button"
                  aria-label="Its a PHOTO ICON!!!">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaHidden(false)
            ->setAriaRole('button')
            ->setAriaLabel("Its a PHOTO ICON!!!")
            ->setFamily('fa')
            ->setIcon('photo')
            ->setStyles('fa-5x')
            ->setTemplate('fa-basic')
            ->render()
        ;
        $html = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testObjectIsClearedAfterReaderForFreshRun_RealWorldTest()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-label="Foo!">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaHidden(false)
            ->setAriaRole('img')
            ->setAriaLabel("Foo!")
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-fw', 'fa-lg')
            ->render();
        $html = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);

        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-hidden="true"
                  aria-label="Icon: Photo (Category: Cat 1)">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaHidden(true)
            ->setIcon('photo')
            ->setStyles('fa-5x')
            ->render('fa');
        $html = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);
    }

    public function testObjectIsClearedAfterReaderForFreshRun_PropertyInspectionTest()
    {
        $expected = $this->sanitizeHtml('
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-label="Foo!">
            </span>'
        );

        $formatter = $this->instantiateClass();
        $html      = $formatter
            ->setAriaHidden(false)
            ->setAriaRole('img')
            ->setAriaLabel("Foo!")
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-fw', 'fa-lg')
            ->render();
        $html = $this->sanitizeHtml($html);

        $this->assertSame($html, $expected);

        $validRoles = [ 'img', 'link', 'button', 'presentation'];

        $this->assertAttributeEquals(null,           'familyEntity',   $formatter);
        $this->assertAttributeEquals(null,           'iconEntity',     $formatter);
        $this->assertAttributeEquals(null,           'iconSlug',       $formatter);
        $this->assertAttributeEquals(null,           'templateEntity', $formatter);
        $this->assertAttributeEquals(null,           'templateSlug',   $formatter);
        $this->assertAttributeEquals([]  ,           'optionalStyles', $formatter);
        $this->assertAttributeEquals(true,           'ariaHidden',     $formatter);
        $this->assertAttributeEquals(null,           'ariaLabel',      $formatter);
        $this->assertAttributeEquals('presentation', 'ariaRole',       $formatter);
        $this->assertAttributeEquals($validRoles,    'validAriaRoles', $formatter);
        $this->assertAttributeInstanceOf(
            'Scribe\SharedBundle\EntityRepository\IconFamilyRepository', 'iconFamilyRepo', $formatter);
        $this->assertAttributeInstanceOf(
            'Symfony\Component\Templating\EngineInterface',              'engine',         $formatter);
    }

    /**
     * @expectedException        Scribe\SharedBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage An icon family type was not provided.
     * @expectedExceptionCode    100
     */
    public function testCanValidateInvalidMissingFontFamilies()
    {
        $formatter = new IconCreator($this->iconFamilyRepoNoFamilyResult, $this->engine);
        $html = $formatter->setIcon('glass')->render();
    }

    /**
     * @expectedException        Scribe\SharedBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage IconFamily with slug not-valid could not be found.
     * @expectedExceptionCode    101
     */
    public function testCanValidateInvalidFontFamilies()
    {
        $formatter = new IconCreator($this->iconFamilyRepoNoFamilyResult, $this->engine);
        $html = $formatter->render('not-valid', 'glass');
    }

    /**
     * @expectedException        Scribe\SharedBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage Could not find icon template slug bad-template in icon family Font Awesome.
     * @expectedExceptionCode    101
     */
    public function testCanValidateInvalidFontTemplates()
    {
        $formatter = $this->instantiateClass();
        $html = $formatter->render('fa', 'glass', 'bad-template');
    }

    /**
     * @expectedException             PHPUnit_Framework_Error
     * @expectedExceptionMessageRegex #Argument 1 passed to .* must be an instance of .*, instance of .* given#
     */
    public function testAttributesTypeHintOnSetter_Family()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setFamilyEntity');

        $badArgument = new \stdClass;
        $method->invokeArgs($obj, [$badArgument]);
    }

    /**
     * @expectedException             PHPUnit_Framework_Error
     * @expectedExceptionMessageRegex #Argument 1 passed to .* must be an instance of .*, instance of .* given#
     */
    public function testAttributesTypeHintOnSetter_Icon()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setIconEntity');

        $badArgument = new \stdClass;
        $method->invokeArgs($obj, [$badArgument]);
    }

    /**
     * @expectedException             PHPUnit_Framework_Error
     * @expectedExceptionMessageRegex #Argument 1 passed to .* must be an instance of .*, instance of .* given#
     */
    public function testAttributesTypeHintOnSetter_Template()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setTemplateEntity');

        $badArgument = new \stdClass;
        $method->invokeArgs($obj, [$badArgument]);
    }

    /**
     * @expectedException             PHPUnit_Framework_Error
     * @expectedExceptionMessageRegex #Argument 1 passed to .* must be an instance of .*, instance of .* given#
     */
    public function testAttributesTypeHintOnSetter_IconFamilyRepo()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setIconFamilyRepo');

        $badArgument = new \stdClass;
        $method->invokeArgs($obj, [$badArgument]);
    }

    /**
     * @expectedException             PHPUnit_Framework_Error
     * @expectedExceptionMessageRegex #Argument 1 passed to .* must be an instance of .*, instance of .* given#
     */
    public function testAttributesTypeHintOnSetter_Engine()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setEngine');

        $badArgument = new \stdClass;
        $method->invokeArgs($obj, [$badArgument]);
    }
}
