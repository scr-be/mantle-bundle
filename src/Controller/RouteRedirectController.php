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
 * Class RouteRedirectController.
 */
class RouteRedirectController extends ControllerBehaviors
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function apiDocsAction()
    {
        return $this->getResponseRedirectByUri('/api/master/index.html');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginDirectorAction()
    {
        return $this->getResponseRedirectByUri(
            $this->getRouteUri('login')
        );
    }

    /**
     * @param string $path
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handleAction($path)
    {
        return $this->getResponseRedirect($path, 301);
    }
}

/* EOF */
