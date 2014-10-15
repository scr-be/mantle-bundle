<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RedirectController
 */
class RedirectController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function apiDocsAction()
    {
        return $this->redirect('/api/master/index.html');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginDirectorAction()
    {
        return $this->redirect(
            $this->generateUrl('login')
        );
    }

    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handleAction($destination)
    {
        return $this->redirect($destination, 301);
    }
}
