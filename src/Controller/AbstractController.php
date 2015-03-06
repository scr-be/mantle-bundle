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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractController
 */
abstract class AbstractController extends Controller
{
    /**
     * @param string[] $which
     * @return array
     */
    public function getServices(array $which = [])
    {
        $services = [];
        foreach ($which as $service_key) {
            $services[] = $this->getServiceSelector($service_key);
        }

        return $services;
    }

    /**
     * @param string $service_key
     * @return object
     */
    protected function getServiceSelector($service_key)
    {
        switch ($service_key) {
            case 'em':
                return $this
                    ->getDoctrine()
                    ->getManager()
                ;
            case 'request':
                return $this
                    ->container
                    ->get('request')
                ;
            case 'session':
                return $this
                    ->container
                    ->get('request')
                    ->getSession()
                ;
            case 'user':
                return $this
                    ->getUser()
                ;
            default:
                return $this
                    ->container
                    ->get($service_key)
                ;
        }
    }

    /**
     * @see Controller::createForm()
     * @param $name
     * @param $type
     * @param null $data
     * @param array $options
     * @return mixed
     */
    public function createNamedForm($name, $type, $data = null, array $options = array())
    {
        return $this->container->get('form.factory')->createNamed($name, $type, $data, $options);
    }
}

/* EOF */
