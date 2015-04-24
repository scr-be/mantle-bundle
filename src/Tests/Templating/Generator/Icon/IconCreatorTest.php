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
use Scribe\MantleBundle\Templating\Generator\Icon\IconCreator;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorMocksTrait;
use Scribe\MantleBundle\Tests\Templating\Generator\Icon\Mocks\IconCreatorHelperTrait;
use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;

/**
 * Class IconCreatorTest.
 */
class IconCreatorTest extends AbstractMantleKernelTestCase
{
    use IconCreatorMocksTrait,
        IconCreatorHelperTrait;

    const FULLY_QUALIFIED_CLASS_NAME_ICON_FAMILY_REPO = 'Scribe\MantleBundle\Doctrine\Repository\Icon\IconFamilyRepository';

    const FULLY_QUALIFIED_CLASS_NAME_TWIG_ENVIRONMENT = 'Twig_Environment';

    const FULLY_QUALIFIED_CLASS_NAME_SELF = 'Scribe\MantleBundle\Templating\Generator\Icon\IconCreator';

    public function setUp()
    {
        parent::setUp();

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
            ->render('glass', 'fa')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
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

        $this->assertXmlStringEqualsXmlString($expected, $html);

        $html = $this
            ->getNewIconCreator()
            ->setIcon('glass')
            ->setFamily('fa')
            ->render()
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
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
            ->render('fa-glass', 'fa');

        $this->assertXmlStringEqualsXmlString($expected, $html);

        $html = $this
            ->getNewIconCreator()
            ->render('glass', 'fa');

        $this->assertXmlStringEqualsXmlString($expected, $html);
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

        $this->assertXmlStringEqualsXmlString($expected, $html);

        $html = $this
            ->getNewIconCreator()
            ->setFamily('fa')
            ->setIcon('glass')
            ->render()
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
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
            ->render('glass', 'fa', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
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
            ->render('glass', 'fa')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
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
            ->render('glass', 'fa', null, 'fa-5x')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testThrowsExceptionOnInvalidOptionalStyles_ShortForm()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'The requested optional style fa-foo is not compatible with the Font Awesome font family.',
            '51'
        );
        $this
            ->getNewIconCreator()
            ->render('glass', 'fa', null, 'fa-foo')
        ;
    }

    public function testThrowsExceptionOnInvalidOptionalStyles_LongForm()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'The requested optional style fa-bad-style is not compatible with the Font Awesome font family.',
            '51'
        );
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
            ->render('glass', 'fa', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testAriaLabelCanBeSetExplicitly()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Glass is half full!">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaLabel('Glass is half full!')
            ->render('glass', 'fa', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testAriaRoleCanBeSetExplicitly()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-hidden="true"
                  aria-label="Glass is half full!">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaRole('img')
            ->setAriaLabel('Glass is half full!')
            ->render('glass', 'fa', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testIconLookupByAlias()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-hidden="true"
                  aria-label="Glass is half full!">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaRole('img')
            ->setAriaLabel('Glass is half full!')
            ->render('glass-half-full', 'fa', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testIconLookupByAlias2()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-photo"
                  role="img"
                  aria-hidden="true"
                  aria-label="Photo label!">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaRole('img')
            ->setAriaLabel('Photo label!')
            ->render('photograph', 'fa', null, 'fa-fw', 'fa-lg')
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testThrowsExceptionOnInvalidAriaRoleValue()
    {
        $this->setExpectedExceptionRegExp(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            '#You attempted to set an invalid aria role attribute. Valid values:.*#',
            '50'
        );
        $this
            ->getNewIconCreator()
            ->setAriaRole('does-not-exists')
            ->render('glass', 'fa', null, 'fa-fw', 'fa-lg')
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

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testOtherIconInFamilyCanBeAccessed()
    {
        $expected  = '
            <span class="fa fa-5x fa-photo"
                  role="button"
                  aria-label="Its a PHOTO ICON!!!">
            </span>'
        ;

        $html = $this
            ->getNewIconCreator()
            ->setAriaHidden(false)
            ->setAriaRole('button')
            ->setAriaLabel('Its a PHOTO ICON!!!')
            ->setFamily('fa')
            ->setIcon('photo')
            ->setStyles('fa-5x')
            ->setTemplate('fa-basic')
            ->render()
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
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
            ->setAriaLabel('Foo!')
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-fw', 'fa-lg')
            ->render();

        $this->assertXmlStringEqualsXmlString($expected, $html);

        $expected = '
            <span class="fa fa-5x fa-photo"
                  role="presentation"
                  aria-hidden="true"
                  aria-label="Icon: Photo (Category: Cat 1)">
            </span>
        ';

        $html = $this
            ->getNewIconCreator()
            ->setAriaHidden(true)
            ->setFamily('fa')
            ->setStyles('fa-5x')
            ->render('photo');

        $this->assertXmlStringEqualsXmlString($expected, $html);
    }

    public function testObjectIsClearedAfterReaderForFreshRun_PropertyInspectionTest()
    {
        $expected = '
            <span class="fa fa-fw fa-lg fa-glass"
                  role="img"
                  aria-label="Foo!">
            </span>
        ';

        $validRoles = ['img', 'link', 'button', 'presentation'];

        $formatter = $this->getNewIconCreator();

        $html = $formatter
            ->setAriaHidden(false)
            ->setAriaRole('img')
            ->setAriaLabel('Foo!')
            ->setFamily('fa')
            ->setIcon('glass')
            ->setStyles('fa-fw', 'fa-lg')
            ->render()
        ;

        $this->assertXmlStringEqualsXmlString($expected, $html);
        $this->assertAttributeEquals(null,           'familyEntity',   $formatter);
        $this->assertAttributeEquals(null,           'iconEntity',     $formatter);
        $this->assertAttributeEquals(null,           'iconSlug',       $formatter);
        $this->assertAttributeEquals(null,           'templateEntity', $formatter);
        $this->assertAttributeEquals(null,           'templateSlug',   $formatter);
        $this->assertAttributeEquals([],             'optionalStyles', $formatter);
        $this->assertAttributeEquals(true,           'ariaHidden',     $formatter);
        $this->assertAttributeEquals(null,           'ariaLabel',      $formatter);
        $this->assertAttributeEquals('presentation', 'ariaRole',       $formatter);
        $this->assertAttributeEquals($validRoles,    'validAriaRoles', $formatter);
        $this->assertAttributeInstanceOf(
            self::FULLY_QUALIFIED_CLASS_NAME_ICON_FAMILY_REPO, 'iconFamilyRepo', $formatter);
        $this->assertAttributeInstanceOf(
            self::FULLY_QUALIFIED_CLASS_NAME_TWIG_ENVIRONMENT, 'twigEnv',         $formatter);
    }

    public function testCanValidateInvalidMissingFontFamilies()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'An icon family type was not provided.',
            '100'
        );
        (new IconCreator($this->iconFamilyRepoNoFamilyResult, $this->engine))
            ->setIcon('glass')
            ->render()
        ;
    }

    public function testCanValidateInvalidFontFamilies()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorORMException',
            'IconFamily with slug not-valid could not be found.',
            '5040'
        );
        (new IconCreator($this->iconFamilyRepoNoFamilyResult, $this->engine))
            ->render('glass', 'not-valid')
        ;
    }

    public function testCanValidateInvalidFontTemplates()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorORMException',
            'Could not find icon template slug bad-template in icon family Font Awesome.',
            '5040'
        );
        $this
            ->getNewIconCreator()
            ->render('glass', 'fa', 'bad-template')
        ;
    }

    public function testAttributesTypeHintOnSetter_Family()
    {
        $this->setExpectedExceptionRegExp(
            'PHPUnit_Framework_Error',
            '#Argument 1 passed to .* must be an instance of .*, instance of .* given#'
        );

        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setFamilyEntity');

        $badArgument = new \stdClass();
        $method->invokeArgs($obj, [$badArgument]);
    }

    public function testAttributesTypeHintOnSetter_Icon()
    {
        $this->setExpectedExceptionRegExp(
            'PHPUnit_Framework_Error',
            '#Argument 1 passed to .* must be an instance of .*, instance of .* given#'
        );

        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setIconEntity');

        $badArgument = new \stdClass();
        $method->invokeArgs($obj, [$badArgument]);
    }

    public function testAttributesTypeHintOnSetter_Template()
    {
        $this->setExpectedExceptionRegExp(
            'PHPUnit_Framework_Error',
            '#Argument 1 passed to .* must be an instance of .*, instance of .* given#'
        );

        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setTemplateEntity');

        $badArgument = new \stdClass();
        $method->invokeArgs($obj, [$badArgument]);
    }

    public function testAttributesTypeHintOnSetter_IconFamilyRepo()
    {
        $this->setExpectedExceptionRegExp(
            'PHPUnit_Framework_Error',
            '#Argument 1 passed to .* must be an instance of .*, instance of .* given#'
        );

        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setIconFamilyRepo');

        $badArgument = new \stdClass();
        $method->invokeArgs($obj, [$badArgument]);
    }

    public function testAttributesTypeHintOnSetter_Engine()
    {
        $this->setExpectedExceptionRegExp(
            'PHPUnit_Framework_Error',
            '#Argument 1 passed to .* must be an instance of .*, instance of .* given#'
        );

        list($obj, $method) = $this->getReflectionOfIconCreatorForMethod('setTwigEnv');

        $badArgument = new \stdClass();
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

    public function testValidateIconExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'An icon type was not provided.',
            '100'
        );
        list($obj, $v) = $this->getReflectionOfIconCreatorForMethods('validateIcon');

        $v->invokeArgs($obj, []);
    }

    public function testLookupIconNoFontFamilyExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'Could not validate/lookup icon entity without a valid icon family entity.',
            '7000'
        );
        list($obj, $l) = $this->getReflectionOfIconCreatorForMethods('lookupIcon');

        $l->invokeArgs($obj, []);
    }

    public function testLookupIconNoFontFamilyIconsExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorORMException',
            'Could not find icon slug  in icon family Font Awesome.',
            '5040'
        );
        list($obj, $l, $g, $s) = $this->getReflectionOfIconCreatorForMethods('lookupIcon', 'getFamilyEntity', 'setFamilyEntity');

        $family = $this->mockIconFamily();
        $family
            ->method('getIcons')
            ->willReturn(new ArrayCollection())
        ;

        $s->invokeArgs($obj, [$family]);
        $l->invokeArgs($obj, []);
    }

    public function testLookupTemplateNoFontFamilyExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'Could not validate/lookup icon template entity without a valid icon family entity.',
            '7000'
        );
        list($obj, $l) = $this->getReflectionOfIconCreatorForMethods('lookupTemplate');

        $l->invokeArgs($obj, []);
    }

    public function testLookupTemplateNoFontFamilyTemplatesExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorORMException',
            'No icon templates are associated with the Font Awesome icon family.',
            '5040'
        );
        list($obj, $l, $g, $s) = $this->getReflectionOfIconCreatorForMethods('lookupTemplate', 'getFamilyEntity', 'setFamilyEntity');

        $family = $this->mockIconFamily();
        $family
            ->method('getTemplates')
            ->willReturn(new ArrayCollection())
        ;

        $s->invokeArgs($obj, [$family]);
        $l->invokeArgs($obj, []);
    }

    public function testLookupStylesUserSpecifiedByNoFontFamilySpecifiedOptionalStylesExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'No available optional styles to select for Font Awesome font family.',
            '51'
        );
        list($obj, $l, $o, $s) = $this->getReflectionOfIconCreatorForMethods('lookupStyles', 'setOptionalStyles', 'setFamilyEntity');

        $family = $this->mockIconFamilyNoOptionalClasses();

        $s->invokeArgs($obj, [$family]);

        $o->invokeArgs($obj, ['one', 'two', 'three']);
        $l->invokeArgs($obj, []);
    }

    public function testValidateEngineUnknownTypeExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'The icon template entity is invalid; cannot verify the template engine.',
            50
        );

        $engine = $this->getMock('Twig_Environment');
        $obj = new IconCreator($this->iconFamilyRepo, $engine);
        $refFormat = new \ReflectionClass(IconCreatorTest::FULLY_QUALIFIED_CLASS_NAME_SELF);

        $validateEngine = $refFormat->getMethod('validateEngine');
        $validateEngine->setAccessible(true);
        $validateEngine->invokeArgs($obj, []);
    }

    public function testValidateEngineInvalidTypeExceptionHandling()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException',
            'The icon template requested this-is-not-a-valid-engine engine, but we are running the twig engine.',
            '50'
        );
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
