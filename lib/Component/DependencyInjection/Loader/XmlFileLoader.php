<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Loader;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader as SymfonyXmlFileLoader;

/**
 * Class XmlFileLoader.
 */
class XmlFileLoader extends SymfonyXmlFileLoader
{
    /**
     * Overwrite the default constructor behaviour to do nothing, so we can defer
     * setup until the user explicitly calls {@see setup}.
     */
    public function __construct()
    {
    }

    /**
     * Having deferred setup previously, this method handles calling the parent
     * constructor {@see parent::__construct} to setup the object as it normally
     * would be.
     *
     * @param ContainerBuilder $container   The container instance being built
     * @param FileLocator      $fileLocator A file locator instance
     *
     * @return FileLoader
     */
    public function setup(ContainerBuilder $container, FileLocator $fileLocator)
    {
        return parent::__construct($container, $fileLocator);
    }
}

/* EOF */
