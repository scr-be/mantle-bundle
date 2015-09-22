<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Icon;

use Twig_Environment;
use Scribe\Wonka\Exception\RuntimeException;
use Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException;

/**
 * IconCreatorInterface.
 */
interface IconCreatorInterface
{
    /**
     * Set the icon family slug; this can be validated immediately.
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setFamily($slug);

    /**
     * Set the icon slug; validation must be postponed until rendering.
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setIcon($slug);

    /**
     * Set the icon template slug; validation must be postponed until rendering.
     *
     * @param $slug
     *
     * @return $this
     */
    public function setTemplate($slug = null);

    /**
     * Set additional styles for icon; validation must be postpones until rendering.
     *
     * @param string[] $styles
     *
     * @return $this
     */
    public function setStyles(...$styles);

    /**
     * Reset the instance properties of object to default/undefined state.
     *
     * @return $this
     */
    public function resetState();

    /**
     * Render the requested icon.
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string ,... $styles
     *
     * @return string
     *
     * @throws IconCreatorException
     */
    public function render($icon = null, $family = null, ...$styles);

    /**
     * Setter for aria hidden accessibility value.
     *
     * @param bool $hidden
     *
     * @return $this
     */
    public function setAriaHidden($hidden = true);

    /**
     * Reset icon aria hidden accessibility value.
     *
     * @return $this
     */
    public function resetAriaHidden();

    /**
     * Setter for aria label accessibility value.
     *
     * @param null|string $label
     *
     * @return $this
     */
    public function setAriaLabel($label = null);

    /**
     * Reset aria label accessibility value.
     *
     * @return $this
     */
    public function resetAriaLabel();

    /**
     * Setter for aria role accessibility value.
     *
     * @param string $role
     *
     * @return $this
     */
    public function setAriaRole($role);

    /**
     * Reset aria role accessibility value.
     *
     * @return $this
     */
    public function resetAriaRole();

    /**
     * Reset icon family instance property.
     *
     * @return $this
     */
    public function resetFamilyEntity();

    /**
     * Reset icon entity instance property.
     *
     * @return $this
     */
    public function resetIconEntity();

    /**
     * Reset icon slug instance property.
     *
     * @return $this
     */
    public function resetIconSlug();

    /**
     * Reset icon template entity instance property.
     *
     * @return $this
     */
    public function resetTemplateEntity();

    /**
     * Reset icon template slug instance property.
     *
     * @return $this
     */
    public function resetTemplateSlug();

    /**
     * Getter for twig enviornment.
     *
     * @return Twig_Environment|null
     *
     * @throws RuntimeException If engine property has not yet been set.
     */
    public function getEngineEnvironment();

    /**
     * Setter for twig enviornment.
     *
     * @param Twig_Environment|null $engineEnvironment
     *
     * @return $this
     */
    public function setEngineEnvironment(Twig_Environment $engineEnvironment = null);

    /**
     * Checker for twig enviornment.
     *
     * @return bool
     */
    public function hasEngineEnvironment();

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
    public function getEngineRendering($template, $arguments);
}

/* EOF */
