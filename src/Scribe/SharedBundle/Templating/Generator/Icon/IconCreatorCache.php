<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Generator\Icon;

use Scribe\SharedBundle\Templating\Generator\Icon\IconCreatorCached;

/**
 * Icon
 *
 * @package Scribe\SharedBundle\Templating\Generator\Icon
 */
class IconCreatorCache extends IconCreator
{  
    /**
     * Cache for IconCreator states 
     *
     * @var array
     */
    private $iconCreatorCache = array();

    /**
     * current state
     *
     * @var md5 hash
     */
    private $currentState = null;

    /**
     * Render the requested icon
     *
     * @param  string|null $family
     * @param  string|null $icon
     * @param  string|null $template
     * @param  string[]    $styles
     * @return string
     * @throws IconException
     */
    public function render($family = null, $icon = null, $template = null, ...$styles)
    {
        $this->currentState = $this->serializedState();
        if($this->isCached()) {
            return $this->cachedResponse();
        }
        else {
            $html = parent::render($family, $icon, $template, ...$styles);
            $this->setCache($html);
            $this->currentState = null;

            return $html;
        }
    }

    /**
     * Checks if current state has been cached 
     * @return bool
     */
    public function isCached()
    {
        return array_key_exists($this->currentState, $this->iconCreatorCache);
    }

    /**
     * Fetches cached HTML for current state 
     * @return string 
     */
    protected function cachedResponse()
    {
        return (string) $this->iconCreatorCache[$this->currentState];
    }

    /**
     * Set cache for current state to HTML string 
     * @param HTML string
     * @return $this 
     */
    protected function setCache($html)
    {
        $this->iconCreatorCache[$this->currentState] = $html;
         
        return $this;
    }

    /**
     * Serializes current context into md5 hash 
     */
    protected function serializedState()
    {
        return md5(serialize($this));
    }
}

/* EOF */
