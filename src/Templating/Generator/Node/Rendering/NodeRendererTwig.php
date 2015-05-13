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

use Scribe\Utility\ClassInfo;
use Twig_Environment;

/**
 * Class NodeRendererTwig.
 */
class NodeRendererTwig extends AbstractNodeRenderer
{
    /**
     * The supported slug (name) of this renderer.
     *
     * @var string
     */
    const SUPPORTED_NAME = 'twig';

    /**
     * Twig enviornment used to render twig templates from strings.
     *
     * @var Twig_Environment
     */
    private $engineEnvironment;

    /**
     * Construct the renderer with the required Twig_Enviornment.
     *
     * @param Twig_Environment $engineEnvironment
     */
    public function __construct(Twig_Environment $engineEnvironment)
    {
        $this->engineEnvironment = $engineEnvironment;
    }

    /**
     * Gets the value of engineEnvironment.
     *
     * @return Twig_Environment
     */
    public function getEngineEnvironment()
    {
        return $this->engineEnvironment;
    }

    /**
     * Sets the value of engineEnvironment.
     *
     * @param Twig_Environment $engineEnvironment
     *
     * @return $this
     */
    public function setEngineEnvironment(Twig_Environment $engineEnvironment)
    {
        $this->engineEnvironment = $engineEnvironment;

        return $this;
    }

    /**
     * Render a node item.
     *
     * @param string $string The content/template to be rendered
     * @param array  $args   Arguments to pass to the renderer
     *
     * @return string
     *
     * @throws \Twig_Error_Loader When the passed template cannot be found/loaded
     * @throws \Twig_Error_Syntax When the passed template contains a syntax error
     */
    public function render($string, array $args = [])
    {
        $twigTemplate = $this
            ->getEngineEnvironment()
            ->createTemplate($string)
        ;

        return $twigTemplate->render($args);
    }

    /**
     * Get the handler type (generally this will return the class name).
     *
     * @param bool $fqcn
     *
     * @return string
     */
    public function getType($fqcn = false)
    {
        if ($fqcn === true) {
            return (string) ClassInfo::getNamespaceByInstance($this).ClassInfo::getClassNameByInstance($this);
        }

        return self::SUPPORTED_NAME;
    }
}

/* EOF */
