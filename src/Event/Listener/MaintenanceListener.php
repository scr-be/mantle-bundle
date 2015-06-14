<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Event\Listener;

use Scribe\Component\Bundle\BundleInformation;
use Scribe\Component\DependencyInjection\Aware\ServiceContainerAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Scribe\MantleBundle\Component\Controller\Behaviors\ControllerBehaviors;
use Scribe\MantleBundle\Controller\MaintenanceController;

/**
 * Class MaintenanceListener
 * Registered as an event listener that handles detection of a maintenance state
 * on a global or per-bundle basis.
 */
class MaintenanceListener
{
    use ServiceContainerAwareTrait;

    /**
     * Instance of bundle info object.
     *
     * @var BundleInformation
     */
    private $bundleInfo;

    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * The filter event instance generated pre-controller by the kernel.
     *
     * @var FilterControllerEvent
     */
    private $event;

    /**
     * The controller instance.
     *
     * @var ControllerBehaviors
     */
    private $controller;

    /**
     * The maintenance controller.
     *
     * @var MaintenanceController
     */
    private $maintenanceController;

    /**
     * Represents if maintenance mode is enabled.
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
     * state of maintenance mode.
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
     * @param RequestStack          $requestStack
     * @param BundleInformation     $bundleInfo
     * @param MaintenanceController $maintenanceController
     * @param bool                  $enabled
     * @param array|null            $bundles
     * @param array|null            $exempt
     * @param string|null           $overrideArgument
     * @param string|null           $overrideValue
     */
    public function __construct(RequestStack $requestStack, BundleInformation $bundleInfo,
                                MaintenanceController $maintenanceController, $enabled, $bundles, $exempt,
                                $overrideArgument, $overrideValue)
    {
        $this->requestStack = $requestStack;
        $this->bundleInfo = $bundleInfo;
        $this->maintenanceController = $maintenanceController;
        $this->enabled = $enabled;
        $this->bundles = $bundles;
        $this->exempt = $exempt;
        $this->overrideArgument = $overrideArgument;
        $this->overrideValue = $overrideValue;
    }

    /**
     * Called prior to kernel calling default controller.
     *
     * @param FilterControllerEvent $event filter event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (is_array($event->getController()) === false) {
            return;
        }

        $this->event = $event;
        $this->controller = $event->getController()[0];

        if ($this->isDisabled() || $this->isOverridden() ||
            $this->isInvalidController() || $this->isExemptController()) {
            return;
        }

        if ($this->isBundleEnabled()) {
            $this->handleMaintenanceState();
        }
    }

    /**
     * Check if enabled.
     *
     * @return bool
     */
    private function isDisabled()
    {
        return (bool) ($this->enabled !== true);
    }

    /**
     * Check if the controller is an invalid controller.
     *
     * @return bool
     */
    private function isInvalidController()
    {
        return (bool) (false === ($this->controller instanceof ControllerBehaviors));
    }

    /**
     * Check if controller is exempt.
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
     * Check if overridden url paramiter was passed and is accurate.
     *
     * @return bool
     */
    private function isOverridden()
    {
        return ($this->requestStack->getCurrentRequest()->get($this->overrideArgument) === $this->overrideValue ?: false);
    }

    /**
     * Check if bundle maintenance is enabled explicitly or if none are enabled
     * explicitly then maintenance mode is globally enabled.
     *
     * @return bool
     */
    private function isBundleEnabled()
    {
        if (0 === count($this->bundles)) {
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
     * Handle switching the controller and action to the maintenance state.
     */
    private function handleMaintenanceState()
    {
        $this->event->stopPropagation();
        $this->event->setController(
            [$this->maintenanceController, 'displayMaintenanceAction']
        );
    }
}

/* EOF */
