<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Bundle;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class BundleInformation
 *
 * @package Scribe\SharedBundle\Component\Symfony
 */
class BundleInformation
{
    /**
     * @var string
     */
    private $org = null;

    /**
     * @var Request
     */
    private $request = null;

    /**
     * @var string|null
     */
    private $bundle = null;

    /**
     * @var string|null
     */
    private $controller = null;

    /**
     * @var string|null
     */
    private $action = null;

    /**
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();

        $this->handleBundleInformationExtraction();
    }

    public function getFullBundleName()
    {
        return $this->getOrg() . $this->getBundle() . 'bundle';
    }

    /**
     * @return string|null
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @return string|null
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string|null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getOrg()
    {
        if ($this->org === 's') {
            return 'scribe';
        }
        else {
            return $this->org;
        }
    }

    /**
     * @return array
     */
    private function handleBundleInformationExtraction()
    {
        if ($this->request === null) {
            return ['', '', ''];
        }

        $controller = $this->request
            ->attributes
            ->get('_controller')
        ;

        preg_match('#([^\.]*)\.([^\.]*)\.([^\.]*)\.controller:(.*?)Action#i', $controller, $matches);

        if (!isset($matches[1]) and !isset($matches[2]) and !isset($matches[3])) {
            $matches = [];
            preg_match('#(.*?)\\\(.*?\\\)?(.*?)Bundle\\\Controller\\\(.*?)Controller::(.*?)Action#i', $controller, $matches);
        }

        if (sizeof($matches) == 6) {
            $offset = 1;
        }
        else {
            $offset = 0;
        }

        $this->bundle     = isset($matches[2+$offset]) ? strtolower($matches[2+$offset]) : null;
        $this->controller = isset($matches[3+$offset]) ? strtolower($matches[3+$offset]) : null;
        $this->action     = isset($matches[4+$offset]) ? strtolower($matches[4+$offset]) : null;
        $this->org        = isset($matches[1])         ? strtolower($matches[1])         : null;
    }
}
