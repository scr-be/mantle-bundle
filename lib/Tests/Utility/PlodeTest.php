<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility;

use PHPUnit_Framework_TestCase;
use Scribe\Utility\Plode;
use Scribe\Exception\BadFunctionCallException;

class PlodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Cannot instantiate static class Scribe\Utility\Plode.
     */
    public function shouldThrowExceptionOnInstantiation()
    {
        new Plode();
    }

    /**
     * @test
     */
    public function shouldImplodeArrayToString()
    {
        $result = Plode::im(['one', 'two', 'three'], Plode::SEPARATOR_COMMA);
        $this->assertEquals($result, 'one,two,three');
    }

    /**
     * @test
     */
    public function shouldExplodeStringToArray()
    {
        $result = Plode::ex('one,two,three', Plode::SEPARATOR_COMMA);
        $this->assertEquals($result, ['one', 'two', 'three']);
    }

    /**
     * @test
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Expected method format is "[im|ex]OnSeparator" for example "imOnComma".
     */
    public function shouldThrowExceptionOnInvalidArgumentCountNotEnoughMagicMethodCall()
    {
        Plode::imOnComma();
    }

    /**
     * @test
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Expected method format is "[im|ex]OnSeparator" for example "imOnComma".
     */
    public function shouldThrowExceptionOnInvalidArgumentCountTooManyMagicMethodCall()
    {
        Plode::imOnComma('one', 'two');
    }

    /**
     * @test
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Expected method format is "[im|ex]OnSeparator" for example "imOnComma".
     */
    public function shouldThrowExceptionOnInvalidStrSizeMagicMethodCall()
    {
        Plode::a();
    }

    /**
     * @test
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Valid method prefixes are "im" for "implode" and "ex" for "explode".
     */
    public function shouldThrowExceptionOnInvalidStr01MagicMethodCall()
    {
        Plode::aaOnComma('one,two,three');
    }

    /**
     * @test
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Expected method format is "[im|ex]OnSeparator" for example "imOnComma" but exAaComma
     *                           was provided.
     */
    public function shouldThrowExceptionOnInvalidStr23MagicMethodCall()
    {
        Plode::exAAComma('one,two,three');
    }

    /**
     * @test
     * @expectedException        BadFunctionCallException
     * @expectedExceptionMessage Invalid separator type of aa provided.
     */
    public function shouldThrowExceptionOnInvalidStr4nMagicMethodCall()
    {
        Plode::exOnAA('one,two,three');
    }

    /**
     * @test
     */
    public function shouldImplodeArrayToStringUsingMagicMethodWithCommaSeparator()
    {
        $result = Plode::imOnComma(['one', 'two', 'three']);
        $this->assertEquals($result, 'one,two,three');
    }

    /**
     * @test
     */
    public function shouldImplodeArrayToStringUsingMagicMethodWithColonSeparator()
    {
        $result = Plode::imOnColon(['one', 'two', 'three']);
        $this->assertEquals($result, 'one:two:three');
    }
}

/* EOF */
