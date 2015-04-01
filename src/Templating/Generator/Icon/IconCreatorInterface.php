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
use Scribe\MantleBundle\EntityRepository\IconFamilyRepository;

/**
 * Interface IconInterface.
 */
interface IconCreatorInterface
{
    public function __construct(IconFamilyRepository $iconFamilyRepo, Twig_Environment $twigEnv = null);
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
