<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Extension;

use Scribe\MantleBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\MantleBundle\Templating\Extension\Part\ContainerAwareExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Twig_Extension;

/**
 * Class GetLastUsernameExtension.
 */
class GetLastUsernameExtension extends Twig_Extension
{
    use SimpleExtensionTrait,
        ContainerAwareExtensionTrait;

    /**
     * constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->init('get_last_username');
    }

    /**
     * @return mixed
     */
    public function get_last_username()
    {
        $session = $this
            ->container
            ->get('session')
        ;

        return (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);
    }
}
