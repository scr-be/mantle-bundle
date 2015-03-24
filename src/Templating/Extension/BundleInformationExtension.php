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

use Scribe\MantleBundle\Templating\Extension\Part\AdvancedExtensionTrait;
use Scribe\Component\Bundle\BundleInformation;
use Twig_Extension;

/**
 * Class BundleInformationExtension.
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
