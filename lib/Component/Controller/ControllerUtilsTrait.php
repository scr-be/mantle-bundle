<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Controller;

/**
 * Class ControllerUtilsTrait
 *
 * @package Scribe\Component\Controller
 */
trait ControllerUtilsTrait
{
    /**
     * Instance of controller utils
     *
     * @var ControllerUtils
     */
    protected $utils;

    /**
     * Setter for utils instance
     *
     * @param ControllerUtils $utils object instance
     */
    public function setUtils(ControllerUtils $utils)
    {
        $this->utils = $utils;
    }

    /**
     * Getter for utils instance
     *
     * @return ControllerUtils
     */
    public function getUtils()
    {
        return $this->utils;
    }

    /**
     * Short-hand alias for {@see getUtils}
     *
     * @return ControllerUtils
     */
    public function u()
    {
        return $this->getUtils();
    }
}
