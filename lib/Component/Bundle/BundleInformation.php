<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Bundle;

use Scribe\Component\DependencyInjection\Aware\RouterAwareTrait;
use Scribe\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Scribe\Component\DependencyInjection\Aware\RequestStackAwareTrait;
use Scribe\Utility\Error\DeprecationErrorHandler;
use Scribe\Exception\InvalidArgumentException;
use Scribe\Exception\RuntimeException;
use Symfony\Component\Routing\Route;

/**
 * BundleInformation
 *
 * Determine the org, bundle name, controller name, and action name. This can be determined via
 * the current request, a provided route index or route object, or a provided string. The values
 * are parsed from the string from one of the mentioned methods using a regular expression.
 *
 * If you use the default Symfony folder layout and do not use the "controller as a service"
 * setup, you may have luck using the {@see BundleInformation::REGEX_CONTROLLER_NAMESPACE} const.
 *
 * Alternatively, if you use the "controller as a service" setup, as we at Scribe do, you will
 * may use the {@see BundleInformation::REGEX_CONTROLLER_SERVICE_ID} const, but this assumes you
 * have used our controller service name syntax:
 *     {org}.{bundle}.{controller}.controller
 * For example, a controller within the namespace Scribe\BlogBundle\Controller\SiteMapController
 * would be defined as a service with the following name:
 *     scribe.blog.site_map.controller
 * If you use your own standard for controller service names, you will need to
 *
 *
 *
 * Parses the org, bundle, controller, and action from the Request's _controller
 * attribute based on the provided specified regular expression.
 */
class BundleInformation implements BundleInformationInterface
{
    use RequestStackAwareTrait;
    use RouterAwareTrait;

    /**
     * @var null|string
     */
    protected $frameworkProvidedLocation;

    /**
     * @var null|string
     */
    protected $mode;

    /**
     * @var null|string
     */
    protected $regex;

    /**
     * @var null|string
     */
    protected $bundle;

    /**
     * @var null|string
     */
    protected $controller;

    /**
     * @var null|string
     */
    protected $action;

    /**
     * @var null|string
     */
    protected $org;

    /**
     * Set's up the request environment and then parses the controller request string if auto handling is enabled.
     *
     * @param RequestStack $requestStack
     * @param Router       $router
     * @param bool         $autoHandle
     * @param null|string  $mode
     * @param null|string  $regex
     *
     * @throws InvalidArgumentException
     */
    public function __construct(RequestStack $requestStack, Router $router, $autoHandle = true, $mode = null, $regex = null)
    {
        $this
            ->setRequestStack($requestStack)
            ->setRouter($router)
            ->setMode($mode !== null ? $mode : self::MODE_REQUEST)
            ->setRegex($regex !== null ? $regex : self::REGEX_CONTROLLER_SERVICE_ID);

        if ($autoHandle === true) { $this->handle(); }
    }

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = (string) $mode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set the controller string derived from the request object variable.
     *
     * @param string $frameworkProvidedLocation
     *
     * @return $this
     */
    public function setFrameworkProvidedLocation($frameworkProvidedLocation)
    {
        $this->frameworkProvidedLocation = (string) $frameworkProvidedLocation;

        return $this;
    }

    /**
     * Get the request controller string.
     *
     * @return null|string
     */
    public function getFrameworkProvidedLocation()
    {
        return $this->frameworkProvidedLocation;
    }

    /**
     * Setter for regex property.
     *
     * @param string $regex The regex to parse bundle info from request _controller parameter
     *
     * @return $this
     */
    public function setRegex($regex)
    {
        $this->regex = (string) $regex;

        return $this;
    }

    /**
     * Getter for regex property.
     *
     * @return null|string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Setter for org property.
     *
     * @param string $org An org name
     *
     * @return $this
     */
    public function setOrg($org)
    {
        $this->org = (string) $org;

        return $this;
    }

    /**
     * Getter for org property.
     *
     * @return null|string
     */
    public function getOrg()
    {
        return $this->org;
    }

    /**
     * Setter for bundle property.
     *
     * @param string $bundle A bundle name
     *
     * @return $this
     */
    public function setBundle($bundle)
    {
        $this->bundle = (string) $bundle;

        return $this;
    }

    /**
     * Getter for bundle property.
     *
     * @return null|string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Setter for controller property.
     *
     * @param string $controller A controller name
     *
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = (string) $controller;

        return $this;
    }

    /**
     * Getter for controller property.
     *
     * @return null|string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Setter for action property.
     *
     * @param string $action An action name
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = (string) $action;

        return $this;
    }

    /**
     * Getter for action property.
     *
     * @return null|string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Getter for the full bundle name.
     *
     * @return string
     */
    public function getFullBundleName()
    {
        return (string) $this->getOrg().$this->getBundle().'bundle';
    }

    /**
     * Get all bundle-related property elements as an array.
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
            $this->getFullBundleName(),
        ];
    }

    /**
     * Handle determining the bundle information, or bailing if no request is present.
     *
     * @param null|string $mode
     * @param null|string $value
     *
     * @return $this
     */
    public function handle($mode = null, $value = null)
    {
        $mode = $mode !== null ? $mode : $this->getMode();

        switch($mode) {
            case self::MODE_REQUEST:
                $this->determineFrameworkLocationByRequest();
                break;

            case self::MODE_ROUTE:
                $this->determineFrameworkLocationByRoute($value);
                break;

            case self::MODE_STRING:
                $this->setFrameworkProvidedLocation($value);
                break;

            default:
                throw new LogicException('Invalid mode provided to %s method in %s.', null, null, null, __FUNCTION__, __CLASS__);
        }

        $this->determineParts();

        return $this;
    }

    /**
     * Get the request _controller parameter.
     *
     * @return $this
     */
    protected function determineFrameworkLocationByRequest()
    {
        if ($this->hasRequestStack() === true && $this->hasMasterRequest() === true &&
            $this->getMasterRequest()->attributes->has('_controller'))
        {
            $this->setFrameworkProvidedLocation(
                $this->getMasterRequest()->attributes->get('_controller')
            );
        }

        return $this;
    }

    /**
     * Get the route default _controller parameter.
     *
     * @param string $routeName
     *
     * @return $this
     */
    protected function determineFrameworkLocationByRoute($routeName)
    {
        $route = $this
            ->getRouter()
            ->getRouteCollection()
            ->get($routeName);

        if (false === ($route instanceof Route) || false === $route->hasDefault('_controller')) {
            return $this;
        }

        $this->setFrameworkProvidedLocation(
            $route->getDefault('_controller')
        );

        return $this;
    }

    /**
     * Parse the Request _controller parameter using the provided regex to populate
     * the org, bundle, controller, and action properties.
     *
     * @return $this
     */
    public function determineParts()
    {
        list($org, $bundle, $controller, $action) =
            $this->parseParts()
        ;

        $this
            ->setOrg($org)
            ->setBundle($bundle)
            ->setController($controller)
            ->setAction($action)
        ;

        return $this;
    }

    /**
     * Handle the actual parsing of the _controller Request parameter.
     *
     * @return string[]
     */
    protected function parseParts()
    {
        $unknownReturnArray = [null, null, null, null];

        if (false === (strlen($this->frameworkProvidedLocation) > 0) || false === (strlen($this->regex) > 0)) {
            return $unknownReturnArray;
        }

        if (false === preg_match($this->regex, $this->frameworkProvidedLocation, $matches) ||
            false === (count($matches) > 0))
        {
            return $unknownReturnArray;
        }

        array_walk($matches, function (&$v, $i) { $v = strtolower($v); });
        unset($matches[0]);

        return (array) array_values($matches);
    }
}

/* EOF */
