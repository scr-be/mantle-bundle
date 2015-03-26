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
trait HasRouteParameters
{
    /**
     * @var array
     */
    private $routeParameters;

    /**
     * init trait.
     */
    public function __initRouteParameters()
    {
        $this->routeParameters = [];
    }

    /**
     * Set routeParameters.
     *
     * @param array $routeParameters
     *
     * @return $this
     */
    public function setRouteParameters(array $routeParameters = [])
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }

    /**
     * Get routeParameters.
     *
     * @return array
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }
}

/* EOF */
