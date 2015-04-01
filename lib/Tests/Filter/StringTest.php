<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Filter;

use Scribe\Tests\Helper\MantleFrameworkHelper;
use Scribe\Filter\String;

class StringTest extends MantleFrameworkHelper
{
    /**
     * @var Scribe\Filter\String
     */
    protected $filterString;

    public function setUp()
    {
        parent::setUp();

        $this->filterString = new String;
    }

    public function testAlphanumericOnly()
    {
        $data = [
            ['abcdef0-#ehs!738', 'abcdef0-ehs738'],
            ['#$(%*#(#@)$(@..;', ''],
            ['untouched0123456', 'untouched0123456'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->alphanumericOnly($d[0]);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testSpacesToDashes()
    {
        $data = [
            ['  abc d efg', '--abc-d-efg'],
            ['           ', '-----------'],
            ['#*(DS 923  ', '#*(DS-923--'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->spacesToDashes($d[0]);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testDashedToSpaces()
    {
        $data = [
            ['  abc d efg', '--abc-d-efg'],
            ['           ', '-----------'],
            ['#*(DS 923  ', '#*(DS-923--'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->dashedToSpaces($d[1]);
            $this->assertEquals($d[0], $actual);
        }
    }

    public function testAlphanumericAndDashesOnlyDefaultFunction()
    {
        $data = [
            ['abcdef0-#ehs!738', 'abcdef0-ehs738'],
            ['#$(%*#(#@)$(@..;-', '-'],
            ['untou--ed01-3456', 'untou--ed01-3456'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->alphanumericAndDashesOnly($d[0]);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testAlphanumericAndDashesOnlyCustomFunction()
    {
        $data = [
            ['ABCdef0-#ehs!738', 'ABCDEF0-EHS738'],
            ['#$(%*#(#@)$(@..;-', '-'],
            ['UNTOU--ED01-3456', 'UNTOU--ED01-3456'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->alphanumericAndDashesOnly($d[0], 'strtoupper');
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testAlphanumericAndDashesOnlyNullFunction()
    {
        $data = [
            ['ABCdef0-#ehs!738', 'ABCdef0-ehs738'],
            ['#$(%*#(#@)$(@..;-', '-'],
            ['untou--ed01-3456', 'untou--ed01-3456'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->alphanumericAndDashesOnly($d[0], null);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testParsePhoneNumber()
    {
        $data = [
            ['+1 123 123 1234', '1231231234'],
            ['(860)322 - 1284', '8603221284'],
            ['832.443.2312', '8324432312'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->parsePhoneString($d[0]);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testFormatPhoneNumber()
    {
        $data = [
            ['1234567890', '+1 (123) 456-7890'],
            ['839', '839'],
            ['1231231234', '+1 (123) 123-1234'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->formatPhoneString($d[0]);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testTitleCase()
    {
        $data = [
            ['a cool house and it is not cool', 'A Cool House and It Is Not Cool'],
            ['this should <em>be title cased</em>', 'This Should <em>Be Title Cased</em>'],
            ['a cool house (and it is not cool)', 'A Cool House (And It Is Not Cool)'],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->titleCase($d[0]);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testMultibyteStringComparison()
    {
        $data = [
            ['abcdef0123', 'abcdef0123', true],
            ['ß', 'ß', true],
            ['漢字はユニコード', '漢字はユニコード', true],
            ['ß', 'ss', false], //no support for this yet...
            ['ß', 'sz', false], //sadly
            ['abc', 'defg', false],
            ['012', 'abc', false],
        ];

        foreach ($data as $d) {
            $actual = $this->filterString->mb_strnatcasecmp($d[0], $d[1]);
            $this->assertEquals($d[2], $actual);
        }
    }
}

/* EOF */
