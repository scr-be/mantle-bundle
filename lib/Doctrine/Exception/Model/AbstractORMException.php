<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Exception\Model;

use Scribe\Exception\Model\ExceptionTrait;

/**
 * Class AbstractORMException.
 */
abstract class AbstractORMException extends \Doctrine\ORM\ORMException implements ORMExceptionInterface
{
    use ExceptionTrait;
}

/* EOF */
