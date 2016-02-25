<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Bundle;

/**
 * BundleInformationInterface.
 */
interface BundleInformationInterface
{
    /**
     * Handle info parsing/determination using master request controller attribute.
     *
     * @var string
     */
    const MODE_REQUEST = 'request';

    /**
     * Handle info parsing/determination using controller determined from route name.
     *
     * @var string
     */
    const MODE_ROUTE = 'route';

    /**
     * Handle info parsing/determination using provided string.
     *
     * @var string
     */
    const MODE_STRING = 'string';

    /**
     * Regular expression to use for Scribe's controller service name convention.
     *
     * @var string
     */
    const REGEX_CONTROLLER_SERVICE_ID = '#([^\.]*)\.([^\.]*)\.([^\.]*)\.controller:(.*?)Action#i';

    /**
     * Regular expression to use for Symfony's default file layout for controller (not
     * defined as services).
     *
     * @var string
     */
    const REGEX_CONTROLLER_NAMESPACE = '#(.*?)\\\(.*?)Bundle\\\Controller\\\(.*?)Controller::(.*?)Action#i';

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setMode($mode);

    /**
     * @return null|string
     */
    public function getMode();

    /**
     * Set the controller string derived from the request object variable.
     *
     * @param string $frameworkProvidedLocation
     *
     * @return $this
     */
    public function setFrameworkProvidedLocation($frameworkProvidedLocation);

    /**
     * Get the request controller string.
     *
     * @return null|string
     */
    public function getFrameworkProvidedLocation();

    /**
     * Setter for regex property.
     *
     * @param string $regex The regex to parse bundle info from request _controller parameter
     *
     * @return $this
     */
    public function setRegex($regex);

    /**
     * Getter for regex property.
     *
     * @return null|string
     */
    public function getRegex();

    /**
     * Setter for org property.
     *
     * @param string $org An org name
     *
     * @return $this
     */
    public function setOrg($org);

    /**
     * Getter for org property.
     *
     * @return null|string
     */
    public function getOrg();

    /**
     * Setter for bundle property.
     *
     * @param string $bundle A bundle name
     *
     * @return $this
     */
    public function setBundle($bundle);

    /**
     * Getter for bundle property.
     *
     * @return null|string
     */
    public function getBundle();

    /**
     * Setter for controller property.
     *
     * @param string $controller A controller name
     *
     * @return $this
     */
    public function setController($controller);

    /**
     * Getter for controller property.
     *
     * @return null|string
     */
    public function getController();

    /**
     * Setter for action property.
     *
     * @param string $action An action name
     *
     * @return $this
     */
    public function setAction($action);

    /**
     * Getter for action property.
     *
     * @return null|string
     */
    public function getAction();

    /**
     * Getter for the full bundle name.
     *
     * @return string
     */
    public function getFullBundleName();

    /**
     * Get all bundle-related property elements as an array.
     *
     * @return string[]
     */
    public function getAll();

    /**
     * Handle determining the bundle information, or bailing if no request is present.
     *
     * @param null|string $mode
     * @param null|string $value
     *
     * @return $this
     */
    public function handle($mode = null, $value = null);

    /**
     * Parse the Request _controller parameter using the provided regex to populate
     * the org, bundle, controller, and action properties.
     *
     * @return $this
     */
    public function determineParts();
}

/* EOF */
