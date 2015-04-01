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

use Scribe\Tests\Helper\AbstractMantleUnitTestHelper;
use Scribe\Utility\Caller\Call;

class CallTest extends AbstractMantleUnitTestHelper
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Utility\Caller\Call.'
        );

        new Call();
    }

    public function testShouldThrowExceptionOnInvalidFunctionCall()
    {
        $this->setExpectedException(
            'Scribe\Exception\BadFunctionCallException'
        );

        Call::func('this_function_does_not_exist');
    }

    public function testShouldResultInPhpErrorOnInvalidFunctionArgument()
    {
        $this->setExpectedException(
            'Symfony\Component\Debug\Exception\ContextErrorException',
            'Warning: strtolower() expects parameter 1 to be string, array given'
        );

        $result = Call::func('strtolower', ['an', 'array']);
        $this->assertFalse($result);
    }

    public function testShouldReturnResultOnFunctionCall()
    {
        $phpVersion = Call::func('phpversion');
        $this->assertEquals($phpVersion, phpVersion());
    }

    public function testShouldReturnResultOnFunctionCallWithSingleStringArgument()
    {
        $string = Call::func('strtolower', 'STRING');
        $this->assertEquals($string, 'string');
    }

    public function testShouldReturnResultOnFunctionCallWithSingleArrayArgument()
    {
        $array = Call::func('array_keys', ['one', 'two', 'three']);
        $this->assertEquals($array, [0, 1, 2]);
    }

    public function testShouldReturnResultOnFunctionCallWithMultipleStringArguments()
    {
        $array = Call::func('explode', ',', 'one,two,three');
        $this->assertEquals($array, ['one', 'two', 'three']);
    }

    public function testShouldReturnResultOnFunctionCallWithMultipleMixedArguments()
    {
        $string = Call::func('implode', ',', ['one', 'two', 'three']);
        $this->assertEquals($string, 'one,two,three');
    }

    public function testShouldThrowExceptionOnInvalidMethodCall()
    {
        $this->setExpectedException(
            'Scribe\Exception\BadFunctionCallException'
        );
        $exception = new \Exception();
        Call::method($exception, 'method_does_not_exist');
    }

    public function testShouldReturnResultOnMethodCall()
    {
        $exception = new \Exception('This is an exception');
        $result    = Call::method($exception, 'getMessage');
        $this->assertEquals($result, 'This is an exception');
    }

    public function testShouldThrowExceptionOnInvalidStaticMethodCall()
    {
        $this->setExpectedException(
            'Scribe\Exception\BadFunctionCallException'
        );
        Call::staticMethod('\Datetime', 'static_method_does_not_exist');
    }

    public function testShouldReturnResultOnStaticMethodCall()
    {
        $time   = time();
        $result = Call::staticMethod('\Datetime', 'createFromFormat', 'Y', $time);
        $this->assertEquals($result, \Datetime::createFromFormat('Y', $time));
    }
}

/* EOF */
