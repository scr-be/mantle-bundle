<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\AdvancedExtensionTrait;
use Scribe\Component\Bundle\BundleInformation;
use Twig_Extension;

/**
 * Class BundleInformationExtension
 *
 * @package Scribe\SharedBundle\Templating\Extension
 */
class BundleInformationExtension extends Twig_Extension
{
    use AdvancedExtensionTrait;

    /**
     * @var BundleInformation
     */
    private $bundleInformation;

    /**
     * @param BundleInformation $bundleInformation
     */
    public function __construct(BundleInformation $bundleInformation)
    {
        $this->bundleInformation = $bundleInformation;

        $this->addFunctionMethod('getBundleName',     'get_info_bundle');
        $this->addFunctionMethod('getControllerName', 'get_info_controller');
        $this->addFunctionMethod('getActionName',     'get_info_action');
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
