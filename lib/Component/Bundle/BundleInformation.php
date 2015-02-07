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

use Scribe\Component\DependencyInjection\RequestStackAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * Use the RequestStack trait
     */
    use RequestStackAwareTrait;

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
    private $controllerAttributeValue;

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
     * Set's up the request environment and then parses the controller request string
     * 
     * @param   RequestStack $requestStack
     * @throws  InvalidArgumentException
     */
    public function __construct(RequestStack $requestStack)
    {
        $this
            ->setRequestStack($requestStack)
            ->determineRequestMasterFromRequestStack()
        ;

        if (false === ($this->requestStack instanceof RequestStack)) {
            throw new InvalidArgumentException('Invalid Request Stack provided in '.__CLASS__);
        }

        $this
            ->setRegex(self::CONTROLLER_SERVICEID_REGEX)
            ->handle()
        ;

        return $this;
    }

    /**
     * Set the controller string derrived from the request object variable
     * 
     * @param  $controllerAttributeValue string
     * @return $this
     */
    public function setControllerAttributeValue($controllerAttributeValue)
    {
        $this->controllerAttributeValue = $controllerAttributeValue;

        return $this;
    }

    /**
     * Get the request controller string
     * 
     * @return string
     */
    public function getControllerAttributeValue()
    {
        return (string) $this->controllerAttributeValue;
    }

    /**
     * Setter for regex property
     * 
     * @param  string $regex The regex to parse bundle info from request _controller parameter
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
        return (array)[
            $this->getOrg(),
            $this->getBundle(),
            $this->getController(),
            $this->getAction(),
            $this->getFullBundleName()
        ];
    }

    /**
     * Handle determining the bundle information, or bailing if no request is present
     * @return $this
     */
    public function handle()
    {
        if (false === $this->hasRequestMaster()) {
            return $this;
        }

        $this
            ->determineControllerAttributeValue()
            ->parseControllerAttributeValue()
        ;

        return $this;
    }

    /**
     * Parse the Request _controller parameter using the provided regex to populate
     * the org, bundle, controller, and action properties.
     * 
     * @return $this
     */
    public function parseControllerAttributeValue()
    {
        list($org, $bundle, $controller, $action) =
            $this->parseRequestControllerParts()
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
     * Alias for {@see $this->parseRequestController()} for backwards comparability
     * 
     * @todo   Remove in v2.0.0
     * @return $this
     */
    public function parse()
    {
        $this->parseControllerAttributeValue();
        
        return $this;
    }

    /**
     * Get the request _controller parameter
     * @return $this
     */
    private function determineControllerAttributeValue()
    {
        $this->setControllerAttributeValue(
            $this
                ->requestMaster
                ->attributes
                ->get('_controller')
            )
        ;

        return $this;
    }

    /**
     * Handle the actual parsing of the _controller Request parameter
     * 
     * @return string[]
     */
    private function parseRequestControllerParts()
    {
        $matchResult = preg_match($this->getRegex(), $this->getControllerAttributeValue(), $matches);

        if (empty($this->getControllerAttributeValue())) {
            return ['ukn', 'ukn', 'ukn', 'ukn'];
        }

        if (false === $matchResult) {
            throw new RuntimeException('Encountered an error running preg_match.');
        }
        elseif (0 === $matchResult) {
            throw new RuntimeException('Invalid regular expression provided.');
        }
        elseif (4 === count($matches)) {
            throw new RuntimeException('Regular expression did not contain four sub expressions.');
        }

        array_walk($matches, function(&$v, $i) { $v = strtolower($v); });
        unset($matches[0]);

        return (array) array_values($matches);
    }
}
