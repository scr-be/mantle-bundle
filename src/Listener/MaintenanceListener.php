<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Scribe\MantleBundle\Controller\MaintenanceController;
use Scribe\Component\Controller\ControllerUtils;
use Scribe\Component\Bundle\BundleInformation;

/**
 * Class MaintenanceListener
 * Registered as an event listener that handles detection of a maintenance state
 * on a global or per-bundle basis
 *
 * @package Scribe\MantleBundle\Listener
 */
class MaintenanceListener
{
    /**
     * Instance of controller utils
     *
     * @var ControllerUtils
     */
    private $utils;

    /**
     * Instance of bundle info object
     *
     * @var BundleInformation
     */
    private $bundleInfo;

    /**
     * The current request object instance
     *
     * @var Request
     */
    private $request;

    /**
     * The filter event instance generated pre-controller by the kernel
     *
     * @var FilterControllerEvent
     */
    private $event;

    /**
     * The controller instance
     *
     * @var ControllerInterface
     */
    private $controller;

    /**
     * Represents if maintenance mode is enabled
     *
     * @var bool
     */
    private $enabled;

    /**
     * List of bundles that maintenance mode is enabled for. An empty array (no
     * specified bundles) means maintenance mode is enabled globally.
     *
     * @var array
     */
    private $bundles;

    /**
     * List of bundles that are exempt when maintenance mode is enables,
     * regardless of any other configuration options.
     *
     * @var array
     */
    private $exempt;

    /**
     * The URL argument key that can be used to manually override the enabled
     * state of maintenance mode
     *
     * @var string
     */
    private $overrideArgument;

    /**
     * The URL argument value that can be used to manually override the enabled
     * state of maintenance mode.
     *
     * @var string
     */
    private $overrideValue;

    /**
     * Setup the class instance
     *
     */
    public function __construct(ControllerUtils $utils, BundleInformation $bundleInfo, $enabled, $bundles, $exempt, $overrideArgument, $overrideValue)
    {
        $this->utils            = $utils;
        $this->bundleInfo       = $bundleInfo;
        $this->enabled 			= $enabled;
        $this->bundles 	        = $bundles;
        $this->exempt           = $exempt;
        $this->overrideArgument = $overrideArgument;
        $this->overrideValue    = $overrideValue;
        $this->request          = $utils->getService('request');
    }

    /**
     * Called prior to kernel calling default controller
     *
     * @param  FilterControllerEvent $event filter event
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (is_array($event->getController()) === false) {
            return;
        }

        $this->event      = $event;
        $this->controller = $event->getController()[0];

        if ($this->isDisabled() || $this->isExemptController() || $this->isOverridden()) {
            return;
        }

        if ($this->isBundleEnabled()) {
            $this->handleMaintenanceState();
        }
    }

    /**
     * Check if enabled
     *
     * @return bool
     */
    private function isDisabled()
    {
        return (bool)$this->enabled !== true;
    }

    /**
     * Check if controller is exempt
     *
     * @return bool
     */
    private function isExemptController()
    {
        foreach ($this->exempt as $exempt) {
            if ($exempt instanceof $this->controller) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if overridden url paramiter was passed and is accurate
     *
     * @return bool
     */
    private function isOverridden()
    {
        if ($this->request->get($this->overrideArgument) === $this->overrideValue) {
            return true;
        }

        return false;
    }

    /**
     * Check if bundle maintenance is enabled explicitly or if none are enabled
     * explicitly then maintenance mode is globally enabled.
     *
     * @return bool
     */
    private function isBundleEnabled()
    {
        if (sizeof($this->bundles) === 0) {
            return true;
        }

        $fullBundleName = $this->bundleInfo->getFullBundleName();

        foreach ($this->bundles as $bundle) {
            if (strtolower($bundle) === strtolower($fullBundleName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Handle switching the controller and action to the maintenance state
     *
     * @return void
     */
    private function handleMaintenanceState()
    {
        $maintenanceController = new MaintenanceController($this->utils);

        $this->event->stopPropagation();
        $this->event->setController(
            [$maintenanceController, 'displayMaintenanceAction']
        );
    }
}
