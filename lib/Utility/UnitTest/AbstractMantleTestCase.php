<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\UnitTest;

/**
 * Class AbstractMantleTestCase.
 *
 * Basic extension of PHPUnit_Framework_TestCase with additional helper methods.
 */
abstract class AbstractMantleTestCase extends \PHPUnit_Framework_TestCase
{
    use MantleTestCaseTrait;
}
