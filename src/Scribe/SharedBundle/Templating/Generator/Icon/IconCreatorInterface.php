<?php
/*
 * This file is part of scribe-foundation-bundle.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Generator\Icon;

/**
 * Interface IconInterface
 *
 * @package Scribe\SharedBundle\Templating\Generator\Icon
 */
interface IconCreatorInterface
{
    public function setFamily($slug);
    public function setIcon($slug);
    public function setTemplate($slug = null);
    public function setStyles(...$styles);
    public function setAriaHidden($hidden = true);
    public function setAriaLabel($label = null);
    public function setAriaRole($role);
    public function resetState();
    public function render($family = null, $icon = null, $template = null, ...$styles);
}

/* EOF */