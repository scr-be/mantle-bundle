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

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Scribe\MantleBundle\Component\DependencyInjection\Aware\RequestStackAwareTrait;
use Scribe\MantleBundle\Component\DependencyInjection\Aware\RouterAwareTrait;

/**
 * BundleInformationFactory
 * Returns a new bundle information instance.
 */
class BundleInformationFactory
{
    use RequestStackAwareTrait;
    use RouterAwareTrait;

    /**
     * @return BundleInformation
     */
    public static function getInstance(RequestStack $requestStack, Router $router, $autoHandle = false)
    {
        return new BundleInformation($requestStack, $router, $autoHandle);
    }
}

/* EOF */
