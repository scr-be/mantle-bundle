<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Helper\Menu;

/**
 * Interface MenuInterface
 */
interface MenuInterface
{
    /**
     * @return MenuItem
     */
    public function setRouteName($routeName = null);

    /**
     * @return MenuItem
     */
    public function setRouteParameters(array $routeParameters = array());

    /**
     * @return MenuItem
     */
    public function setRoute($routeName = null, array $routeParameters = array());

    /**
     * @return string
     */
    public function generateUrl();
}
