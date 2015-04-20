<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Controller;

use Scribe\Component\Controller\Exception\InvalidArgumentControllerException;
use Scribe\Component\Controller\Exception\InvalidMagicCallControllerException;

/**
 * Class ControllerBasicUtilitiesTrait.
 */
trait ControllerBasicUtilitiesTrait
{
    /**
     * Instance of controller utils.
     *
     * @var ControllerBasicUtilitiesInterface
     */
    private $utils;

    /**
     * @param ControllerBasicUtilitiesInterface $utils
     *
     * @return $this
     */
    public function setUtils(ControllerBasicUtilitiesInterface $utils)
    {
        $this->utils = $utils;

        return $this;
    }

    /**
     * Getter for utils instance.
     *
     * @return ControllerBasicUtilitiesInterface
     */
    public function getUtils()
    {
        return $this->utils;
    }

    /**
     * Attempt to call method on utilities class if it doesn't exist within the controller.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws InvalidArgumentControllerException
     * @throws InvalidMagicCallControllerException
     *
     * @return mixed
     */
    public function __call($method, array $parameters = [])
    {
        if (false === method_exists($this->utils, $method)) {
            throw InvalidMagicCallControllerException::getDefaultInstance(
                get_class($this),
                $method
            );
        }

        try {
            return $this->utils->$method(...$parameters);
        } catch (\Exception $e) {
            throw InvalidArgumentControllerException::getDefaultInstance(
                get_class($this),
                $method,
                $e->getMessage()
            );
        }
    }
}

/* EOF */
