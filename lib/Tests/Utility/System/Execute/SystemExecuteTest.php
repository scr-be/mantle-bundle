<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility\System\Execute;

use Scribe\Utility\System\Execute\SystemExecute;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

class SystemExecuteTest extends AbstractMantleTestCase
{
    public function testFactory()
    {
        static::assertInstanceOf('Scribe\Utility\System\Execute\SystemExecute', SystemExecute::start());
    }

    public function testBasicCommandWithDefaults()
    {
        $cmd = SystemExecute::start()
            ->setCommand('cat /proc/cpuinfo')
            ->run()
        ;

        static::assertTrue($cmd->isSuccess());
        static::assertTrue(is_array($cmd->getOutput()));
    }

    public function testBasicCommandWithCustom()
    {
        $cmd = SystemExecute::start()
            ->setCommand('this-command-does-not-exist-on-any-system')
            ->run()
        ;

        static::assertEquals('this-command-does-not-exist-on-any-system', $cmd->getCommand());
        static::assertFalse($cmd->isSuccess());
        static::assertTrue($cmd->hasReturn());
        static::assertEquals(127, $cmd->getReturn());
        static::assertFalse($cmd->hasOutput());
        static::assertEquals([], $cmd->getOutput());

        $cmd
            ->setExpectedReturn(127)
            ->run()
        ;

        static::assertTrue($cmd->isSuccess());
        static::assertTrue($cmd->hasReturn());
        static::assertEquals(127, $cmd->getReturn());
        static::assertFalse($cmd->hasOutput());
        static::assertEquals([], $cmd->getOutput());

        $cmd
            ->setStdErrToNull(false)
            ->run()
        ;

        static::assertTrue($cmd->isSuccess());
        static::assertTrue($cmd->hasReturn());
        static::assertEquals(127, $cmd->getReturn());
        static::assertTrue($cmd->hasOutput());
        static::assertRegExp('#.*bash.*this-command-does-not-exist-on-any-system.*not found#', $cmd->getOutput()[0]);
    }

    public function testAlternateShellSh()
    {
        $cmd = SystemExecute::start()
            ->setCommand('this-command-does-not-exist-on-any-system')
            ->setExpectedReturn(127)
            ->setStdErrToNull(false)
            ->setShell(SystemExecute::SHELL_SH)
            ->run()
        ;

        static::assertTrue($cmd->isSuccess());
        static::assertTrue($cmd->hasReturn());
        static::assertEquals(127, $cmd->getReturn());
        static::assertTrue($cmd->hasOutput());
        static::assertRegExp('#.*sh.*this-command-does-not-exist-on-any-system.*not found#', $cmd->getOutput()[0]);
    }

    public function testExceptionOnNoCommandDefined()
    {
        $this->setExpectedExceptionRegExp(
            'Scribe\Exception\RuntimeException',
            '#Cannot run an empty command in.*#'
        );

        $cmd = SystemExecute::start()->run();
    }

    public function testComplexCommand()
    {
        $cmd = SystemExecute::start()
            ->setCommand('cat /proc/cpuinfo | grep "model name" | wc -l')
            ->run()
        ;

        static::assertTrue($cmd->isSuccess());
        static::assertTrue($cmd->hasReturn());
        static::assertEquals(0, $cmd->getReturn());
        static::assertTrue($cmd->hasOutput());
        static::assertEquals(['8'], $cmd->getOutput());
    }
}

/* EOF */
