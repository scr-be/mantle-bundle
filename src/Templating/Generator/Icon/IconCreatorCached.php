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

use Symfony\Component\Templating\EngineInterface;
use Scribe\MantleBundle\EntityRepository\IconFamilyRepository;
use Scribe\MantleBundle\Templating\Generator\Icon\IconTraits\IconCreatorCachedServicesTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\IconTraits\IconCreatorCachedAttributesTrait;

/**
 * Class: IconCreatorCached
 *
 * @package Scribe\MantleBundle\Templating\Generator\Icon
 */
class IconCreatorCached extends IconCreator
{
    use IconCreatorCachedServicesTrait,
        IconCreatorCachedAttributesTrait;

    /**
     * Cache for the icon creators 
     *
     * @var array
     */
    private $iconCreatorCache = array();

    /**
     * Setup the object instance
     *
     * @param IconFamilyRepository   $iconFamilyRepo
     * @param EngineInterface        $engine
     * @param UserlandCacheInterface $userlandCache
     */
    public function __construct(IconFamilyRepository $iconFamilyRepo, EngineInterface $engine)
    {
        //$this->setUserlandCache($cache);
        parent::__construct($iconFamilyRepo, $engine);
    }

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
        $this->setCurrentState($family, $icon, $template, ...$styles);

        if($this->isCached()) {
            $html = $this->cachedResponse();
            $this->resetState();

            return $html;
        }
        else {
            if($family == null && $this->hasFamilySlug()) {
                $family = $this->getFamilySlug();
            }            

            $html = parent::render($family, $icon, $template, ...$styles);

            $this->setCache($html);

            $this->currentState = null;
            $this->resetFamilySlug();

            return $html;
        }
    }

    /**
     * Checks if current state has been cached 
     *
     * @return bool
     */
    public function isCached()
    {
        return array_key_exists($this->currentState, $this->iconCreatorCache);
    }

    /**
     * Fetches cached HTML for current state 
     *
     * @return string 
     */
    protected function cachedResponse()
    {
        return (string) $this->iconCreatorCache[$this->currentState];
    }

    /**
     * Set cache for current state to HTML string 
     *
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
     *
     * @param  string|null $family
     * @param  string|null $icon
     * @param  string|null $template
     * @param  string[]    $styles
     * @return $this
     */
    protected function setCurrentState($family, $icon, $template, ...$styles)
    {
        $this
             ->checkAndSetSlug($family,   'setFamilySlug')
             ->checkAndSetSlug($icon,     'setIconSlug')
             ->checkAndSetSlug($template, 'setTemplateSlug')
             ->checkAndSetStyles($styles)
             ->currentState = $this->currentAttributesToMd5();

        return $this;
    }

    /**
     * Checks if slug value given and sets relevant property if so
     *
     * @param  null|string $slugVal
     * @param  string $slugSetter
     * @return $this
     */
    protected function checkAndSetSlug($slugVal, $slugSetter)
    {
        if(null !== $slugVal) {
            $this->{$slugSetter}($slugVal);
        }

        return $this;
    }

    /**
     * Checks if styles values given and sets relevant property if so
     *
     * @param  null|array ...$slugVal
     * @return $this
     */
    protected function checkAndSetStyles($slugVal)
    {
        if(!empty($slugVal)) {
            $this->setStyles(...$slugVal);
        }

        return $this;
    }

    /**
     * Iterates available object variables and returns and md5
     * string of their values, used for caching state
     *
     * @return string
     */
    protected function currentAttributesToMd5()
    {
        $keyString = '';
        foreach(get_object_vars($this) as $property => $value) {
            if($this->nonCacheableProperty($property)) {
                continue;
            }

            $value      = (true === is_array($value)) ? implode($value) : $value;
            $keyString .= (string) $value;
        }

        return md5($keyString);
    }

    /**
     * Determines whether property should be cached (i.e., slugs)
     *
     * @param string $property
     * @return bool
     */
    private function nonCacheableProperty($property)
    {
        if (substr($property, -6, 6) == 'Entity' ||
            substr($property, -4, 4) == 'Repo' ||
            substr($property, -5, 5) == 'Cache' ||
            substr($property, -5, 5) == 'State')
        {

            return true;
        }
        else {

            return false;
        }
    }

    /**
     * Set the icon family slug; not validated, overwrites
     * behavior of parent class
     *
     * @param  string $slug
     * @return $this
     */
    public function setFamily($slug)
    {
        $this->setFamilySlug($slug);

        return $this;
    }

    /**
     * Gets the value of familySlug
     *
     * @return string $familySlug
     */
    public function getFamilySlug()
    {
        return $this->familySlug;
    }
}

/* EOF */
