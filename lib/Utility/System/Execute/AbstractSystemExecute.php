<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\System\Execute;

use Scribe\Exception\RuntimeException;

/**
 * Class AbstractSystemExecute.
 */
abstract class AbstractSystemExecute
{
    /**
     * @var string
     */
    const SHELL_SH = '/bin/sh';

    /**
     * @var string
     */
    const SHELL_BASH = '/bin/bash';

    /**
     * @var string
     */
    protected $shell = self::SHELL_BASH;

    /**
     * @var array
     */
    protected $output;

    /**
     * @var bool
     */
    protected $stdErrToNull = true;

    /**
     * @var int
     */
    protected $return;

    /**
     * @var int
     */
    protected $expectedReturn = 0;

    /**
     * @param string $shell
     *
     * @return $this
     */
    public function setShell($shell)
    {
        $this->shell = $shell;

        return $this;
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return (array) $this->output;
    }

    /**
     * @return bool
     */
    public function hasOutput()
    {
        return (bool) (is_array($this->output) && count($this->output) > 0);
    }

    /**
     * @param bool $stdErrToNull
     *
     * @return $this
     */
    public function setStdErrToNull($stdErrToNull)
    {
        $this->stdErrToNull = (bool) $stdErrToNull;

        return $this;
    }

    /**
     * @return int
     */
    public function getReturn()
    {
        return (int) $this->return;
    }

    /**
     * @return bool
     */
    public function hasReturn()
    {
        return (bool) ($this->return !== null);
    }

    /**
     * @param int $expectedReturn
     *
     * @return $this
     */
    public function setExpectedReturn($expectedReturn)
    {
        $this->expectedReturn = (int) $expectedReturn;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return (bool) ($this->return === $this->expectedReturn);
    }

    /**
     * @return $this
     */
    abstract public function run();

    /**
     * @param mixed $output
     *
     * @return $this
     */
    protected function sanitizeAndSetOutput($output)
    {
        $output = (array) $output;

        array_walk($output, function(&$line) {
            $line = trim($line);
        });

        $this->output = array_filter($output, function($line) {
            return (bool) (strlen($line) > 0);
        });

        return $this;
    }

    /**
     * @param mixed $return
     *
     * @return $this
     */
    protected function sanitizeAndSetReturn($return)
    {
        if (is_int((int) $return)) {
            $this->return = (int) $return;
        }

        return $this;
    }
}

/* EOF */