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
