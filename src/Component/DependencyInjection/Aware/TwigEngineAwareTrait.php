<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\DependencyInjection\Aware;

use Twig_Environment;
use Twig_Template;
use Scribe\Wonka\Exception\RuntimeException;

/**
 * Trait TwigEngineAwareTrait.
 */
trait TwigEngineAwareTrait
{
    /**
     * @var Twig_Environment
     */
    private $engineEnvironment;

    /**
     * @var Twig_Template
     */
    private $twigTpl;

    /**
     * Getter for twig enviornment.
     *
     * @return Twig_Environment|null
     *
     * @throws RuntimeException If engine property has not yet been set.
     */
    public function getEngineEnvironment()
    {
        if (false === $this->hasEngineEnvironment()) {
            throw new RuntimeException('Cannot retrieve twig enviornment as it has not been set.');
        }

        return $this->engineEnvironment;
    }

    /**
     * Setter for twig enviornment.
     *
     * @param Twig_Environment|null $engineEnvironment
     *
     * @return $this
     */
    public function setEngineEnvironment(Twig_Environment $engineEnvironment = null)
    {
        $this->engineEnvironment = $engineEnvironment;

        return $this;
    }

    /**
     * Checker for twig enviornment.
     *
     * @return bool
     */
    public function hasEngineEnvironment()
    {
        return (bool) ($this->engineEnvironment instanceof Twig_Environment);
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
     * @throws \RuntimeException  When engineEnvironment has not been set
     * @throws \Twig_Error_Loader When the passed template cannot be found/loaded
     * @throws \Twig_Error_Syntax When the passed template contains a syntax error
     */
    public function getEngineRendering($template, $arguments)
    {
        $this->twigTpl = $this
            ->getEngineEnvironment()
            ->createTemplate($template)
        ;

        return $this->twigTpl->render($arguments);
    }
}

/* EOF */
