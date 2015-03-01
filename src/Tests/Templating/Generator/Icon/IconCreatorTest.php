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

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreator;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorHelperTrait;

/**
 * Class IconCreatorTest
 *
 * @package Scribe\MantleBundle\Tests\Templating\Generator\Icon
 */
class IconCreatorTest extends PHPUnit_Framework_TestCase
{
    use IconCreatorMocksTrait,
        IconCreatorHelperTrait;

    const FULLY_QUALIFIED_CLASS_NAME_ICON_FAMILY_REPO = 'Scribe\MantleBundle\EntityRepository\IconFamilyRepository';

    const FULLY_QUALIFIED_CLASS_NAME_ENGINE_INTERFACE = 'Symfony\Component\Templating\EngineInterface';

    const FULLY_QUALIFIED_CLASS_NAME_SELF = 'Scribe\MantleBundle\Templating\Generator\Icon\IconCreator';

    public function setUp()
    {
        $this->mockIconEntities();
    }

    public function testRenderShortForm()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->render('fa', 'glass')
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testRenderLongForm()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setFamily('fa')
            ->setIcon('glass')
            ->render()
        ;

        $this->assertSameHtml($html, $expected);

        $html = $this
            ->getNewIconCreator()
            ->setIcon('glass')
            ->setFamily('fa')
            ->render()
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testAcceptsPrefixedAndNonPrefixIconSlug_ShortForm()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->render('fa', 'fa-glass');
        ;

        $this->assertSameHtml($html, $expected);

        $html = $this
            ->getNewIconCreator()
            ->render('fa', 'glass');
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testAcceptsPrefixedAndNonPrefixIconSlug_LongForm()
    {
        $expected = '
            <span class="fa fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';


        $html = $this
            ->getNewIconCreator()
            ->setFamily('fa')
            ->setIcon('fa-glass')
            ->render()
        ;

        $this->assertSameHtml($html, $expected);

        $html = $this
            ->getNewIconCreator()
            ->setFamily('fa')
            ->setIcon('glass')
            ->render()
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testSupportForOptionalStyles_ShortForm()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testSupportForOptionalStyles_LongForm()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setStyles('fa-fw', 'fa-lg')
            ->render('fa', 'glass')
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testSupportForOptionalStylesOverwrittenByRender_LongForm()
    {
        $expected = '
            <span class="fa fa-5x fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setStyles('fa-fw', 'fa-lg')
            ->render('fa', 'glass', null, 'fa-5x')
        ;

        $this->assertSameHtml($html, $expected);
    }

    /**
      * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
      * @expectedExceptionMessage The requested optional style fa-foo is not compatible with the Font Awesome font family.
      * @expectedExceptionCode    51
      */
    public function testThrowsExceptionOnInvalidOptionalStyles_ShortForm()
    {
        $this
            ->getNewIconCreator()
            ->render('fa', 'glass', null, 'fa-foo')
        ;
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage The requested optional style fa-bad-style is not compatible with the Font Awesome font family.
     * @expectedExceptionCode    51
     */
    public function testThrowsExceptionOnInvalidOptionalStyles_LongForm()
    {
        $this
            ->getNewIconCreator()
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-bad-style')
            ->render()
        ;
    }

    public function testAriaHiddenPropertyCanBeDisabled()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaHidden(false)
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testAriaLabelCanBeSetExplicitly()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label=Glass is half full!">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaLabel("Glass is half full!")
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testAriaRoleCanBeSetExplicitly()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-hidden="true"
                  aria-label=Glass is half full!">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaRole("img")
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertSameHtml($html, $expected);
    }

    /**
     * @expectedException             Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessageRegex #You attempted to set an invalid aria role attribute. Valid values:.*#
     * @expectedExceptionCode         50
     */
    public function testThrowsExceptionOnInvalidAriaRoleValue()
    {
        $this
            ->getNewIconCreator()
            ->setAriaRole("does-not-exists")
            ->render('fa', 'glass', null, 'fa-fw', 'fa-lg')
        ;
    }

    public function testSettingTemplate_Long()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Glass (Category: Web Application Icons)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-fw', 'fa-lg')
            ->setTemplate('fa-basic')
            ->render()
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testOtherIconInFamilyCanBeAccessed()
    {
        $expected  = $this->sanitizeHtml('
            <span class="fa fa-5x fa-photo"
                  role="button"
                  aria-label="Its a PHOTO ICON!!!">
            </span>'
        );

        $html = $this
            ->getNewIconCreator()
            ->setAriaHidden(false)
            ->setAriaRole('button')
            ->setAriaLabel("Its a PHOTO ICON!!!")
            ->setFamily('fa')
            ->setIcon('photo')
            ->setStyles('fa-5x')
            ->setTemplate('fa-basic')
            ->render()
        ;

        $this->assertSameHtml($html, $expected);
    }

    public function testObjectIsClearedAfterReaderForFreshRun_RealWorldTest()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-label="Foo!">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaHidden(false)
            ->setAriaRole('img')
            ->setAriaLabel("Foo!")
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-fw', 'fa-lg')
            ->render();

        $this->assertSameHtml($html, $expected);

        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-hidden="true"
                  aria-label="Icon: Photo (Category: Cat 1)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaHidden(true)
            ->setIcon('photo')
            ->setStyles('fa-5x')
            ->render('fa');

        $this->assertSameHtml($html, $expected);
    }

    public function testObjectIsClearedAfterReaderForFreshRun_PropertyInspectionTest()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-label="Foo!">
            </span>
        ';

        $validRoles = [ 'img', 'link', 'button', 'presentation'];

        $formatter = $this->getNewIconCreator();

        $html = $formatter
            ->setAriaHidden(false)
            ->setAriaRole('img')
            ->setAriaLabel("Foo!")
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-fw', 'fa-lg')
            ->render()
        ;

        $this->assertSameHtml($html, $expected);
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
            self::FULLY_QUALIFIED_CLASS_NAME_ICON_FAMILY_REPO, 'iconFamilyRepo', $formatter);
        $this->assertAttributeInstanceOf(
            self::FULLY_QUALIFIED_CLASS_NAME_ENGINE_INTERFACE, 'engine',         $formatter);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage An icon family type was not provided.
     * @expectedExceptionCode    100
     */
    public function testCanValidateInvalidMissingFontFamilies()
    {
        (new IconCreator($this->iconFamilyRepoNoFamilyResult, $this->engine))
            ->setIcon('glass')
            ->render()
        ;
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage IconFamily with slug not-valid could not be found.
     * @expectedExceptionCode    101
     */
    public function testCanValidateInvalidFontFamilies()
    {
        (new IconCreator($this->iconFamilyRepoNoFamilyResult, $this->engine))
            ->render('not-valid', 'glass')
        ;
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage Could not find icon template slug bad-template in icon family Font Awesome.
     * @expectedExceptionCode    101
     */
    public function testCanValidateInvalidFontTemplates()
    {
        $this
            ->getNewIconCreator()
            ->render('fa', 'glass', 'bad-template')
        ;
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

    public function testAttributesHasIconEntity()
    {
        list($obj, $hasIconEntity, $setIconEntity) = $this->getReflectionOfIconCreatorForMethods('hasIconEntity', 'setIconEntity');

        $this->assertFalse($hasIconEntity->invokeArgs($obj, []));
        $setIconEntity->invokeArgs($obj, [$this->mockIcon_Photo()]);

        $this->assertTrue($hasIconEntity->invokeArgs($obj, []));
    }

    public function testAttributesHasTemplateEntity()
    {
        list($obj, $hasTemplateEntity, $setTemplateEntity) = $this->getReflectionOfIconCreatorForMethods('hasTemplateEntity', 'setTemplateEntity');

        $this->assertFalse($hasTemplateEntity->invokeArgs($obj, []));
        $setTemplateEntity->invokeArgs($obj, [$this->mockIconTemplate1()]);

        $this->assertTrue($hasTemplateEntity->invokeArgs($obj, []));
    }

    public function testAttributesHasTemplateSlug()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('hasTemplateSlug');

        $this->assertFalse($method->invokeArgs($obj, []));

        $obj->setTemplate('fa-basic');
        $this->assertTrue($method->invokeArgs($obj, []));
    }

    public function testAttributesHasOptionalStyles()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('hasOptionalStyles');

        $this->assertFalse($method->invokeArgs($obj, []));

        $obj->setStyles('style1', 'style2');
        $this->assertTrue($method->invokeArgs($obj, []));
    }

    public function testAccessibilityGetAriaHidden()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('getAriaHidden');

        $this->assertTrue($method->invokeArgs($obj, []));

        $obj->setAriaHidden(false);
        $this->assertFalse($method->invokeArgs($obj, []));

        $obj->setAriaHidden();
        $this->assertTrue($method->invokeArgs($obj, []));
    }

    public function testAccessibilityIsAriaHidden()
    {
        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('isAriaHidden');

        $this->assertTrue($method->invokeArgs($obj, []));

        $obj->setAriaHidden(false);
        $this->assertFalse($method->invokeArgs($obj, []));

        $obj->setAriaHidden();
        $this->assertTrue($method->invokeArgs($obj, []));
    }

    public function testAccessibilityIsAriaLabel()
    {
        list($obj, $has, $get) = $this->getReflectionOfIconCreatorForMethods('hasAriaLabel', 'getAriaLabel');

        $this->assertFalse($has->invokeArgs($obj, []));

        $obj->setAriaLabel('A label');
        $this->assertTrue($has->invokeArgs($obj, []));
        $this->assertEquals('A label', $get->invokeArgs($obj, []));

        $obj->setAriaLabel();
        $this->assertFalse($has->invokeArgs($obj, []));
    }

    public function testAccessibilityIsAriaRole()
    {
        list($obj, $has, $get) = $this->getReflectionOfIconCreatorForMethods('hasAriaRole', 'getAriaRole');

        $this->assertTrue($has->invokeArgs($obj, []));

        $obj->setAriaRole('button');
        $this->assertTrue($has->invokeArgs($obj, []));
        $this->assertEquals('button', $get->invokeArgs($obj, []));
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage An icon type was not provided.
     * @expectedExceptionCode    100
     */
    public function testValidateIconExceptionHandling()
    {
        list($obj, $v) = $this->getReflectionOfIconCreatorForMethods('validateIcon');

        $v->invokeArgs($obj, []);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage Could not validate/lookup icon entity without a valid icon family entity.
     * @expectedExceptionCode    52
     */
    public function testLookupIconNoFontFamilyExceptionHandling()
    {
        list($obj, $l) = $this->getReflectionOfIconCreatorForMethods('lookupIcon');

        $l->invokeArgs($obj, []);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage Could not find icon slug  in icon family Font Awesome.
     * @expectedExceptionCode    101
     */
    public function testLookupIconNoFontFamilyIconsExceptionHandling()
    {
        list($obj, $l, $g, $s) = $this->getReflectionOfIconCreatorForMethods('lookupIcon', 'getFamilyEntity', 'setFamilyEntity');

        $family = $this->mockIconFamily();
        $family
            ->method('getIcons')
            ->willReturn(new ArrayCollection)
        ;

        $s->invokeArgs($obj, [ $family ]);
        $l->invokeArgs($obj, []);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage Could not validate/lookup icon template entity without a valid icon family entity.
     * @expectedExceptionCode    52
     */
    public function testLookupTemplateNoFontFamilyExceptionHandling()
    {
        list($obj, $l) = $this->getReflectionOfIconCreatorForMethods('lookupTemplate');

        $l->invokeArgs($obj, []);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage No icon templates are associated with the Font Awesome icon family.
     * @expectedExceptionCode    101
     */
    public function testLookupTemplateNoFontFamilyTemplatesExceptionHandling()
    {
        list($obj, $l, $g, $s) = $this->getReflectionOfIconCreatorForMethods('lookupTemplate', 'getFamilyEntity', 'setFamilyEntity');

        $family = $this->mockIconFamily();
        $family
            ->method('getTemplates')
            ->willReturn(new ArrayCollection)
        ;

        $s->invokeArgs($obj, [ $family ]);
        $l->invokeArgs($obj, []);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage No available optional styles to select for Font Awesome font family.
     * @expectedExceptionCode    51
     */
    public function testLookupStylesUserSpecifiedByNoFontFamilySpecifiedOptionalStylesExceptionHandling()
    {
        list($obj, $l, $o, $s) = $this->getReflectionOfIconCreatorForMethods('lookupStyles', 'setOptionalStyles', 'setFamilyEntity');

        $family = $this->mockIconFamilyNoOptionalClasses();

        $s->invokeArgs($obj, [ $family ]);

        $o->invokeArgs($obj, ['one', 'two', 'three']);
        $l->invokeArgs($obj, []);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage Template engine type could not be determined, support cannot be verified.
     * @expectedExceptionCode    50
     */
    public function testValidateEngineUnknownTypeExceptionHandling()
    {
        $engine = $this->getMock('Symfony\Component\Templating\EngineInterface');
        $obj = new IconCreator($this->iconFamilyRepo, $engine);
        $refFormat = new \ReflectionClass(IconCreatorTest::FULLY_QUALIFIED_CLASS_NAME_SELF);

        $validateEngine = $refFormat->getMethod('validateEngine');
        $validateEngine->setAccessible(true);
        $validateEngine->invokeArgs($obj, []);
    }

    /**
     * @expectedException        Scribe\MantleBundle\Templating\Generator\Icon\IconException
     * @expectedExceptionMessage The icon template requested this-is-not-a-valid-engine engine, but we are running the twig engine.
     * @expectedExceptionCode    50
     */
    public function testValidateEngineInvalidTypeExceptionHandling()
    {
        $obj = new IconCreator($this->iconFamilyRepo, $this->engine);
        $refFormat = new \ReflectionClass(IconCreatorTest::FULLY_QUALIFIED_CLASS_NAME_SELF);

        $setTemplateEntity = $refFormat->getMethod('setTemplateEntity');
        $setTemplateEntity->setAccessible(true);
        $setTemplateEntity->invokeArgs($obj, [$this->mockIconTemplateUnknownEngine()]);

        $validateEngine = $refFormat->getMethod('validateEngine');
        $validateEngine->setAccessible(true);
        $validateEngine->invokeArgs($obj, []);

    }
}
