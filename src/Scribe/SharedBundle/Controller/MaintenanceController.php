<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Controller;

use Scribe\Component\Controller\ControllerUtils;

/**
 * Class MaintenanceController
 * Handles display of a system offline page when maintenance mode if activated
 *
 * @package Scribe\SharedBundle\Controller
 */
class MaintenanceController
{
    /**
     * Instance of controller utils
     *
     * @var ControllerUtils
     */
    private $utils;

    /**
     * Constructs the instance with a controller utils property
     *
     * @param ControllerUtils $utils [description]
     */
    public function __construct(ControllerUtils $utils)
    {
        $this->utils = $utils;
    }

    /**
     * Renders and displays the system offline static page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayMaintenanceAction()
    {
        return $this->utils->renderResponse('ScribeSharedBundle:Static:down.html.twig');
    }
}
