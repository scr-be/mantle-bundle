<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Button;

use Scribe\MantleBundle\Component\DependencyInjection\Aware\RouterAwareTrait;
use Scribe\MantleBundle\Component\DependencyInjection\Aware\TranslatorAwareTrait;
use Scribe\MantleBundle\Templating\Generator\AbstractTwigGenerator;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;

/**
 * Class AbstractButtonGenerator.
 */
class ButtonGenerator extends AbstractTwigGenerator
{
    use RouterAwareTrait;
    use TranslatorAwareTrait;

    /**
     * @var string
     */
    protected $tooltip;

    public function __construct(Router $router, Translator $translator, \Twig_Environment $twigEnvironment = null)
    {
        $this->router = $router;
        $this->translator = $translator;
    }
}

/* EOF */
