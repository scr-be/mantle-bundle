<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Controller;

use Scribe\MantleBundle\Component\Controller\Behaviors\ControllerBehaviors;

/**
 * Class MaintenanceController
 *
 * Handles display of a system offline page when maintenance mode if activated.
 */
class MaintenanceController extends ControllerBehaviors
{
    /**
     * Renders and displays the system offline static page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayMaintenanceAction()
    {
        return $this->getResponseTypeHTMLRenderedByTwig(
            'ScribeMantleBundle:Static:down.html.twig'
        );
    }
}

/* EOF */
