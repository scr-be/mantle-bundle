<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Helper\Menu;

/**
 * Interface MenuInterface.
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
