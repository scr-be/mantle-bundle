<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node\Rendering;

use Twig_Environment;

/**
 * Interface NodeTwigRender.
 */
class NodeTwigRender implements NodeRenderingInterface
{
    /**
     * @var Twig_Environment
     */
    private $twigEnv;

    public function __construct(Twig_Environment $twigEnv)
    {
        $this->twigEnv = $twigEnv;
    }

    /**
     * Gets the value of twigEnv.
     *
     * @return Twig_Environment
     */
    public function getTwigEnv()
    {
        return $this->twigEnv;
    }

    /**
     * Sets the value of twigEnv.
     *
     * @param Twig_Environment $twigEnv
     *
     * @return $this
     */
    public function setTwigEnv(Twig_Environment $twigEnv)
    {
        $this->twigEnv = $twigEnv;

        return $this;
    }

    /**
     * @param string $template
     * @param array  $arguments
     *
     * @return string
     *
     * @throws \Twig_Error_Loader When the passed template cannot be found/loaded
     * @throws \Twig_Error_Syntax When the passed template contains a syntax error
     */
    public function render($template, $arguments)
    {
        $twigTemplate = $this
            ->getTwigEnv()
            ->createTemplate($template)
        ;

        return $twigTemplate->render($arguments);
    }
}

/* EOF */
