<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model;

use Scribe\MantleBundle\Entity\Route;

/**
 * Class HasRoute.
 */
trait HasRoute
{
    /**
     * The route property.
     *
     * @var Route
     */
    protected $route;

    /**
     * Init trait
     */
    public function initializeRoute()
    {
        $this->route = null;
    }

    /**
     * Setter for route property.
     *
     * @param Route $route any Route object instance
     *
     * @return $this
     */
    public function setRoute(Route $route = null)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Getter for route property.
     *
     * @return Route|null
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Checker for route property.
     *
     * @return bool
     */
    public function hasRoute()
    {
        return (bool) $this->route instanceof Route;
    }

    /**
     * Nullify the route property.
     *
     * @return $this
     */
    public function clearRoute()
    {
        $this->route = null;

        return $this;
    }
}

/* EOF */
