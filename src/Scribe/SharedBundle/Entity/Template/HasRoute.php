<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

use Scribe\SharedBundle\Entity\Route;

/**
 * Class HasRoute
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasRoute
{
    /**
     * The route property
     *
     * @type Route
     */
    protected $route;

    /**
     * Setter for route property
     *
     * @param Route $route any Route object instance
     * @return $this
     */
    public function setRoute(Route $route = null)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Getter for route property
     *
     * @return Route|null
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Checker for route property
     *
     * @return bool
     */
    public function hasRoute()
    {
        return (bool)$this->route instanceof Route;
    }

    /**
     * Nullify the route property
     *
     * @return $this
     */
    public function clearRoute()
    {
        $this->route = null;

        return $this;
    }
}
