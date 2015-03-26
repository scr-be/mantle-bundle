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
 * Class HasAlias.
 */
trait HasRouteName
{
    /**
     * @var string
     */
    private $routeName;

    /**
     * init trait.
     */
    public function __initRouteName()
    {
        $this->routeName = null;
    }

    /**
     * Set routeName.
     *
     * @param string $routeName
     *
     * @return $this
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName.
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }
}

/* EOF */
