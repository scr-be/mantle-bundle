<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Instruction\Common;

/**
 * Class InstructionCommonInterface.
 */
interface InstructionCommonInterface
{
    /**
     * @param string|null $name
     */
    public function __construct($name = null);

    /**
     * @return string
     */
    public function __toString();

    /**
     * @param mixed $what
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($what, array $arguments = []);

    /**
     * @param mixed $what
     * @param mixed $to
     *
     * @return mixed
     */
    public function __set($what, $to);

    /**
     * @param mixed $what
     *
     * @return mixed
     */
    public function __get($what);

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool
     */
    public function hasName();

    /**
     * @return string
     */
    public function getSelf();

    /**
     * @return string
     */
    public function getType();
}

/* EOF */
