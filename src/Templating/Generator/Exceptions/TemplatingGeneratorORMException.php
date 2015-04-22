<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Exceptions;

use Scribe\Doctrine\Exception\ORMException;
use Scribe\MantleBundle\Templating\Generator\Exceptions\Model\TemplatingGeneratorExtensionInterface;

/**
 * Class TemplatingGeneratorORMException.
 */
class TemplatingGeneratorORMException extends ORMException implements TemplatingGeneratorExtensionInterface {}

/* EOF */
