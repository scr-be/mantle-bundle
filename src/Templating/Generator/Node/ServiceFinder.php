<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ServiceFinder.
 */
class ServiceFinder 
{
    /**
     * @var ContainerInterface 
     */
    private $container = null;

    /**
     * Setup the object instance.
     */
    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
    }

    /**
     * Any call to the object tries to fetch
     * the given string argument as a service
     *
     * @param string
     */
    public function __invoke($service)
    {
        if ($this->container->has($service)) {
            return $this->container->get($service);
        }

        throw new \RuntimeException('Placeholder exception because service not found!');
    }
}
