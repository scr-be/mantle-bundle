<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility\Caller;

use PHPUnit_Framework_TestCase;
use Scribe\Utility\Caller\Call;
use Scribe\Exception\BadFunctionCallException;
use Scribe\Exception\RuntimeException;

class CallTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Cannot instantiate static class Scribe\Utility\Caller\Call.
     */
    public function shouldThrowExceptionOnInstantiation()
    {
        new Call();
    }

    /**
     * @test
     * @expectedException BadFunctionCallException
     */
    public function shouldThrowExceptionOnInvalidFunctionCall()
    {
        Call::func('this_function_does_not_exist');
    }

    /**
     * @test
     * @expectedException        PHPUnit_Framework_Error
     * @expectedExceptionMessage strtolower() expects parameter 1 to be string, array given
     */
    public function shouldResultInPhpErrorOnInvalidFunctionArgument()
    {
        $result = Call::func('strtolower', ['an', 'array']);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function shouldReturnResultOnFunctionCall()
    {
        $phpVersion = Call::func('phpversion');
        $this->assertEquals($phpVersion, phpVersion());
    }

    /**
     * @test
     */
    public function shouldReturnResultOnFunctionCallWithSingleStringArgument()
    {
        $string = Call::func('strtolower', 'STRING');
        $this->assertEquals($string, 'string');
    }

    /**
     * @test
     */
    public function shouldReturnResultOnFunctionCallWithSingleArrayArgument()
    {
        $array = Call::func('array_keys', ['one', 'two', 'three']);
        $this->assertEquals($array, [0, 1, 2]);
    }

    /**
     * @test
     */
    public function shouldReturnResultOnFunctionCallWithMultipleStringArguments()
    {
        $array = Call::func('explode', ',', 'one,two,three');
        $this->assertEquals($array, ['one', 'two', 'three']);
    }

    /**
     * @test
     */
    public function shouldReturnResultOnFunctionCallWithMultipleMixedArguments()
    {
        $string = Call::func('implode', ',', ['one', 'two', 'three']);
        $this->assertEquals($string, 'one,two,three');
    }

    /**
     * @test
     * @expectedException BadFunctionCallException
     */
    public function shouldThrowExceptionOnInvalidMethodCall()
    {
        $exception = new \Exception();
        Call::method($exception, 'method_does_not_exist');
    }

    /**
     * @test
     */
    public function shouldReturnResultOnMethodCall()
    {
        $exception = new \Exception('This is an exception');
        $result    = Call::method($exception, 'getMessage');
        $this->assertEquals($result, 'This is an exception');
    }

    /**
     * @test
     * @expectedException BadFunctionCallException
     */
    public function shouldThrowExceptionOnInvalidStaticMethodCall()
    {
        Call::staticMethod('\Datetime', 'static_method_does_not_exist');
    }

    /**
     * @test
     */
    public function shouldReturnResultOnStaticMethodCall()
    {
        $time   = time();
        $result = Call::staticMethod('\Datetime', 'createFromFormat', 'Y', $time);
        $this->assertEquals($result, \Datetime::createFromFormat('Y', $time));
    }
}

/* EOF */
