<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension\Part;

use Scribe\Utility\Config\ConfigInterface;

/**
 * Class ConfigExtensionTrait
 */
trait ConfigExtensionTrait
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param $key
     * @param bool $container
     * @return mixed
     */
    public function getConfig($key, $container = false)
    {
        return $this->config->get($key);
    }
}
