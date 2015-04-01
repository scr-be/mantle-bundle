<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Templating\Engine;

use Twig_Environment;
use Twig_Template;
use Scribe\Exception\RuntimeException;

/**
 * Trait TwigEngineAwareTrait.
 */
trait TwigEngineAwareTrait
{
    /**
     * @var Twig_Environment
     */
    private $twigEnv;

    /**
     * @var Twig_Template
     */
    private $twigTpl;

    /**
     * Getter for twig enviornment
     *
     * @return Twig_Environment|null
     *
     * @throws RuntimeException If engine property has not yet been set.
     */
    public function getTwigEnv()
    {
        if (false === $this->hasTwigEnv()) {
            throw new RuntimeException('Cannot retrieve twig enviornment as it has not been set.');
        }

        return $this->twigEnv;
    }

    /**
     * Setter for twig enviornment
     *
     * @param Twig_Environment|null $twigEnv
     *
     * @return $this
     */
    public function setTwigEnv(Twig_Environment $twigEnv = null)
    {
        $this->twigEnv = $twigEnv;

        return $this;
    }

    /**
     * Checker for twig enviornment
     *
     * @return bool
     */
    public function hasTwigEnv()
    {
        return (bool) ($this->twigEnv instanceof Twig_Environment);
    }

    /**
     * Attempt to determine the engine type.
     *
     * @return string|false
     */
    public function getEngineType()
    {
        return 'twig';
    }

    /**
     * @param string $template
     * @param array  $arguments
     *
     * @return string
     *
     * @throws \RuntimeException  When twigEnv has not been set
     * @throws \Twig_Error_Loader When the passed template cannot be found/loaded
     * @throws \Twig_Error_Syntax When the passed template contains a syntax error
     */
    public function getEngineRendering($template, $arguments)
    {
        $this->twigTpl = $this
            ->getTwigEnv()
            ->createTemplate($template)
        ;

        return $this->twigTpl->render($arguments);
    }
}

/* EOF */
