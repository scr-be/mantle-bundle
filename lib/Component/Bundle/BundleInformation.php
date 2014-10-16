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
use Symfony\Component\HttpFoundation\Request;
use Scribe\Component\DependencyInjection\RequestAwareTrait;
use Scribe\Exception\InvalidArgumentException;
use Scribe\Exception\RuntimeException;

/**
 * BundleInformation
 * Parses the org, bundle, controller, and action from the Request's _controller
 * attribute based on the provided specified regular expression.
 *
 * @package Scribe\Component\Bundle
 */
class BundleInformation implements BundleInformationInterface
{
    use RequestAwareTrait;

    /**
     * @var string
     */
    const CONTROLLER_SERVICEID_REGEX = '#([^\.]*)\.([^\.]*)\.([^\.]*)\.controller:(.*?)Action#i';

    /**
     * @var string
     */
    const CONTROLLER_NAMESPACE_REGEX = '#(.*?)\\\(.*?)Bundle\\\Controller\\\(.*?)Controller::(.*?)Action#i';

    /**
     * @var string
     */
    private $regex;

    /**
     * @var string
     */
    private $bundle;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $org;

    /**
     * Construct the object and obtain the symfony object information
     *
     * @param  RequestStack $requestStack Instance of the Symfony Request Stack
     *
     * @return $this
     */
    public function __construct(RequestStack $requestStack)
    {
        if (false === ($requestStack->getCurrentRequest() instanceof Request)) {
            throw new InvalidArgumentException;
        }

        $this->setRegex(self::CONTROLLER_SERVICEID_REGEX);

        return $this;
    }

    /**
     * Setter for regex property
     *
     * @param  string $regex The regex to parse bundle info from request _controller paramiter
     *
     * @return $this
     */
    public function setRegex($regex)
    {
        $this->regex = (string) $regex;

        return $this;
    }

    /**
     * Getter for regex property
     *
     * @return string
     */
    public function getRegex()
    {
        return (string) $this->regex;
    }

    /**
     * Setter for org property
     *
     * @param  string $org An org name
     *
     * @return $this
     */
    public function setOrg($org)
    {
        $this->org = (string) $org;

        return $this;
    }

    /**
     * Getter for org property
     *
     * @return string
     */
    public function getOrg()
    {
        return (string) $this->org;
    }

    /**
     * Setter for bundle property
     *
     * @param  string $bundle A bundle name
     *
     * @return $this
     */
    public function setBundle($bundle)
    {
        $this->bundle = (string) $bundle;

        return $this;
    }

    /**
     * Getter for bundle property
     *
     * @return string
     */
    public function getBundle()
    {
        return (string) $this->bundle;
    }

    /**
     * Setter for controller property
     *
     * @param  string $controller A controller name
     *
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = (string) $controller;

        return $this;
    }

    /**
     * Getter for controller property
     *
     * @return string
     */
    public function getController()
    {
        return (string) $this->controller;
    }

    /**
     * Setter for action property
     *
     * @param  string $action An action name
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = (string) $action;

        return $this;
    }

    /**
     * Getter for action property
     *
     * @return string|null
     */
    public function getAction()
    {
        return (string) $this->action;
    }

    /**
     * Getter for the full bundle name
     *
     * @return string
     */
    public function getFullBundleName()
    {
        return (string) $this->getOrg() . $this->getBundle() . 'bundle';
    }

    /**
     * Get all bundle-related property elements as an array
     *
     * @return string[]
     */
    public function getAll()
    {
        return (array) [
            $this->getOrg(),
            $this->getBundle(),
            $this->getController(),
            $this->getAction(),
            $this->getFullBundleName()
        ];
    }

    /**
     * Parse the Request _controller parameter using the provided regex to populate
     * the org, bundle, controller, and action properties.
     *
     * @return $this
     */
    public function parse()
    {
        $requestController = $this->getRequestControllerParameter();

        list($org, $bundle, $controller, $action) =
            $this->parseRequestControllerParts($requestController)
        ;

        return (object) $this;
    }

    /**
     * Get the request _controller paramiter
     *
     * @return string
     */
    private function getRequestControllerParameter()
    {
        return (string) $this
            ->request
            ->attributes
            ->get('_controller')
        ;
    }

    /**
     * Handle the actual parsing of the _controller Request parameter
     *
     * @param  string $requestController Value of the _controller Request parameter
     * @return string[]
     */
    private function parseRequestControllerParts($requestController)
    {
        $matchResult = preg_match($this->getRegex(), $requestController, $matches);

        if (false === $matchResult) {
            throw new RuntimeException('Encountered an error running preg_match.');
        }
        elseif (0 === $matchResult) {
            throw new RuntimeException('Invalid regular expression provided.');
        }
        elseif (5 === count($matches)) {
            throw new RuntimeException('Regular expression did not contain four sub expressions.');
        }

        array_walk($matches, function(&$v, $i) { $v = strtolower($v); });
        unset($matches[0]);

        return (array) array_values($matches);
    }
}
