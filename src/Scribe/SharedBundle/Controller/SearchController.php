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

use Scribe\SharedBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SearchController
 */
class SearchController extends AbstractController
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function queryAction()
    {
        list($request) = $this->getServices(['request']);
        $q = $request->get('q');

        $response = new JsonResponse();
        $response->setData([

        ]);

        return $response;
    }
}
