<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Extension;

use Scribe\MantleBundle\Component\Bundle\BundleInformation;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class BundleInformationExtension.
 */
class BundleInformationExtension extends AbstractTwigExtension
{
    /**
     * @var BundleInformation
     */
    private $bundleInformation;

    /**
     * @param BundleInformation $bundleInformation
     */
    public function __construct(BundleInformation $bundleInformation)
    {
        parent::__construct();

        $this->bundleInformation = $bundleInformation;

        $this->addFunction('get_info_object',     [$this, 'getBundleObject']);
        $this->addFunction('get_info_bundle',     [$this, 'getBundleName']);
        $this->addFunction('get_info_controller', [$this, 'getControllerName']);
        $this->addFunction('get_info_action',     [$this, 'getActionName']);
    }

    /**
     * @return BundleInformation
     */
    public function getBundleObject()
    {
        return $this->bundleInformation;
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return $this->bundleInformation->getBundle();
    }

    /**
     * @return string
     */
    public function getControllerName()
    {
        return $this->bundleInformation->getController();
    }

    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->bundleInformation->getAction();
    }
}

/* EOF */
