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

use Scribe\Tests\Helper\MantleFrameworkHelper;
use Scribe\Utility\Extension;

class ExtensionTest extends MantleFrameworkHelper
{
    public function testThrowsExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Utility\Extension'
        );

        new Extension();
    }

    public function testIgbinaryIsEnabled()
    {
        $this->assertTrue(Extension::hasIgbinary());
    }

    public function testJsonIsEnabled()
    {
        $this->assertTrue(Extension::hasJson());
    }

    public function testReflectIsEnabled()
    {
        $this->assertTrue(Extension::isEnabled('Reflection'));
    }

    public function testUnknownExtensionIsNotEnabled()
    {
        $this->assertFalse(Extension::isEnabled('this-extension-does-not-exist'));
    }

    public function testExceptionOnEmptyString()
    {
        $this->setExpectedException(
            'Scribe\Exception\RuntimeException',
            'Cannot check extension availability against empty string in Scribe\Utility\Extension.'
        );

        Extension::isEnabled('');
    }
}

/* EOF */
