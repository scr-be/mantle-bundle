<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Template;

/**
 * Class HasCode
 *
 * @package Scribe\MantleBundle\Entity\Template
 */
trait HasCode
{
    /**
     * The code property
     *
     * @type string
     */
    protected $code;

    /**
     * Setter for code property
     *
     * @param string|null $code the code string
     * @return $this
     */
    public function setCode($code = null)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Getter for code property
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Checker for code property
     *
     * @return bool
     */
    public function hasCode()
    {
        return (bool) ($this->getCode() !== null);
    }

    /**
     * Nullify the code property
     *
     * @return $this
     */
    public function clearCode()
    {
        $this->code = null;

        return $this;
    }
}

/* EOF */
