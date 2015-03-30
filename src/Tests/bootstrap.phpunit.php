<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

require_once __DIR__.'/bootstrap.functions.php';
require_once __DIR__.'/bootstrap.kernel.php';

define('PHPUNIT_VERSION_MIN', '4.5');

if (!class_exists('PHPUnit_Framework_TestCase') ||
    version_compare(PHPUnit_Runner_Version::id(), PHPUNIT_VERSION_MIN) < 0) {
    logicException(
        'PHPUnit framework (version >=%s) is required for testing.',
        PHPUNIT_VERSION_MIN
    );
}

/* EOF */
