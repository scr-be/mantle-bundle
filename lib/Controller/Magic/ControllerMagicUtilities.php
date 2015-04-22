<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Controller\Magic;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Exception\InvalidArgumentException;
use Scribe\Component\DependencyInjection\Exception\InvalidContainerServiceException;

/**
 * Class ControllerMagicUtilities.
 */
class ControllerMagicUtilities implements ControllerMagicUtilitiesInterface
{
    use ControllerMagicUtilitiesTrait;
}

/* EOF */
