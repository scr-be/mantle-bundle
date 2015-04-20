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

/**
 * Interface ControllerBasicUtilitiesTraitInterface.
 */
interface ControllerBasicUtilitiesTraitInterface
{
    /**
     * Setter for utils instance.
     *
     * @param ControllerBasicUtilitiesInterface $utils A controller utility object instance.
     */
    public function setUtils(ControllerBasicUtilitiesInterface $utils);

    /**
     * Getter for utils instance.
     *
     * @return ControllerBasicUtilitiesInterface
     */
    public function getUtils();

    /**
     * Attempt to call method on utilities class if it doesn't exist within the controller.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws \Scribe\Component\Controller\Exception\InvalidArgumentControllerException
     * @throws \Scribe\Component\Controller\Exception\InvalidMagicCallControllerException
     *
     * @return mixed
     */
    public function __call($method, array $parameters = []);
}

/* EOF */
