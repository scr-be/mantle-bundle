<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Component\Template;

/**
 * Class HasCode
 *
 * @package Scribe\SharedBundle\Component\Template
 */
trait IconAccessibility
{
    // Do the icons serve only the purpose of presentation/styling? 
    private $presentationOnly = false;

    // Optional alternate/accessibility text
    private $accessibilityText = null;

    // Getter/Setters/Checkers for both items
    public function getPresentationOnly()
    {
        return (bool) $this->presentationOnly;
    }

    public function setPresentationOnly($presentationOnly)
    {
        $this->presentationOnly = (bool) $presentationOnly;

        return $this;
    }

    public function isPresentationOnly()
    {
        return $this->getPresentationOnly();
    }

    public function getAccessibilityText()
    {
        return (string) $this->accessibilityText;
    }

    public function setAccessibilityText($accessibilityText = null)
    {
        $this->accessibilityText = (string) $accessibilityText;
    }

    public function hasAccessibilityText()
    {
        return (bool) ($this->accessibilityText !== null);
    }

}
