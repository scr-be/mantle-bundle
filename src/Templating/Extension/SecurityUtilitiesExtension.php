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

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Scribe\WonkaBundle\Component\Templating\AbstractTwigExtension;

/**
 * Class SecurityUtilitiesExtension.
 */
class SecurityUtilitiesExtension extends AbstractTwigExtension
{
    /**
     * Initialize the instance.
     *
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * Initialize the instance.
     *
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        parent::__construct();

        $this->authenticationUtils = $authenticationUtils;

        $this
            ->enableOptionHtmlSafe()
            ->addFunction('get_last_username', [$this, 'getLastUsername']);
    }

    /**
     * @return string
     */
    public function getLastUsername()
    {
        return (string) $this->authenticationUtils->getLastUsername();
    }
}

/* EOF */
