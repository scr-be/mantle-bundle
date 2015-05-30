<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility;

use Scribe\Utility\UnitTest\AbstractMantleTestCase;
use Scribe\Utility\Plode;
use Scribe\Exception\BadFunctionCallException;

class PlodeTest extends AbstractMantleTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Cannot instantiate static class Scribe\Utility\Plode.'
        );
        new Plode();
    }

    public function testShouldImplodeArrayToString()
    {
        $result = Plode::im(['one', 'two', 'three'], Plode::SEPARATOR_COMMA);
        static::assertEquals($result, 'one,two,three');
    }

    public function testShouldExplodeStringToArray()
    {
        $result = Plode::ex('one,two,three', Plode::SEPARATOR_COMMA);
        static::assertEquals($result, ['one', 'two', 'three']);
    }

    public function testShouldThrowExceptionOnInvalidArgumentCountNotEnoughMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Expected method format is "[im|ex]OnSeparator" for example "imOnComma".'
        );
        Plode::imOnComma();
    }

    public function testShouldThrowExceptionOnInvalidArgumentCountTooManyMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Expected method format is "[im|ex]OnSeparator" for example "imOnComma".'
        );
        Plode::imOnComma('one', 'two');
    }

    public function testShouldThrowExceptionOnInvalidStrSizeMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Expected method format is "[im|ex]OnSeparator" for example "imOnComma".'
        );
        Plode::a();
    }

    public function testShouldThrowExceptionOnInvalidStr01MagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Valid method prefixes are "im" for "implode" and "ex" for "explode".'
        );
        Plode::aaOnComma('one,two,three');
    }

    /**
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Expected method format is "[im|ex]OnSeparator" for example "imOnComma" but exAaComma
     *                           was provided.
     */
    public function testShouldThrowExceptionOnInvalidStr23MagicMethodCall()
    {
        Plode::exAAComma('one,two,three');
    }

    public function testShouldThrowExceptionOnInvalidStr4nMagicMethodCall()
    {
        $this->setExpectedException(
            'BadFunctionCallException',
            'Invalid separator type of aa provided.'
        );
        Plode::exOnAA('one,two,three');
    }

    public function testShouldImplodeArrayToStringUsingMagicMethodWithCommaSeparator()
    {
        $result = Plode::imOnComma(['one', 'two', 'three']);
        static::assertEquals($result, 'one,two,three');
    }

    public function testShouldImplodeArrayToStringUsingMagicMethodWithColonSeparator()
    {
        $result = Plode::imOnColon(['one', 'two', 'three']);
        static::assertEquals($result, 'one:two:three');
    }
}

/* EOF */
