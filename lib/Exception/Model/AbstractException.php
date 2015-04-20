<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Exception\Model;

/**
 * Class AbstractException.
 */
abstract class AbstractException extends \Exception implements ExceptionInterface
{
    use ExceptionTrait;
}

/* EOF */
