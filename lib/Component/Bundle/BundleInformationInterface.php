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

/**
 * BundleInformationInterface.
 */
interface BundleInformationInterface
{
    /**
     * Handle info parseing/determenation using master request controller attribute
     *
     * @var string
     */
    const MODE_REQUEST = 'request';

    /**
     * Handle info parseing/determenation using provided string
     *
     * @var string
     */
    const MODE_STRING = 'string';

    /**
     * Handle info parseing/determenation using controller determined from route name
     *
     * @var string
     */
    const MODE_ROUTE = 'route';

    /**
     * Setter for regex property.
     *
     * @param string $regex The regex to parse bundle info from request _controller paramiter
     */
    public function setRegex($regex);

    /**
     * Getter for regex property.
     */
    public function getRegex();

    /**
     * Setter for org property.
     *
     * @param string $org An org name
     */
    public function setOrg($org);

    /**
     * Getter for org property.
     */
    public function getOrg();

    /**
     * Setter for bundle property.
     *
     * @param string $bundle A bundle name
     */
    public function setBundle($bundle);

    /**
     * Getter for bundle property.
     */
    public function getBundle();

    /**
     * Setter for controller property.
     *
     * @param string $controller A controller name
     */
    public function setController($controller);

    /**
     * Getter for controller property.
     */
    public function getController();

    /**
     * Setter for action property.
     *
     * @param string $action An action name
     */
    public function setAction($action);

    /**
     * Getter for action property.
     */
    public function getAction();

    /**
     * Getter for the full bundle name.
     */
    public function getFullBundleName();

    /**
     * Get all bundle-related property elements as an array.
     */
    public function getAll();

    /**
     * Parse the Request _controller parameter using the provided regex to populate
     * the org, bundle, controller, and action properties.
     *
     * @return $this
     */
    public function parse();
}

/* EOF */
