<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\EntityTrait;

/**
 * Class HasContext.
 */
trait HasContext
{
    /**
     * The context property.
     *
     * @var string
     */
    protected $context;

    /**
     * Setter for context property.
     *
     * @param string|null $context the context string
     *
     * @return $this
     */
    public function setContext($context = null)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Getter for context property.
     *
     * @return string|null
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Checker for context property.
     *
     * @return bool
     */
    public function hasContext()
    {
        return (bool) ($this->getContext() !== null);
    }

    /**
     * Nullify the context property.
     *
     * @return $this
     */
    public function clearContext()
    {
        $this->context = null;

        return $this;
    }
}

/* EOF */
