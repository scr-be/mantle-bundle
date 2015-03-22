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

use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChainInterface;
use Symfony\Component\Templating\EngineInterface;
use Scribe\MantleBundle\EntityRepository\IconFamilyRepository;
use Scribe\MantleBundle\Templating\Generator\Icon\IconTraits\IconCreatorCachedServicesTrait;
use Doctrine\ORM\EntityRepository;

/**
 * Class: IconCreatorCached
 *
 * @package Scribe\MantleBundle\Templating\Generator\Icon
 */
class IconCreatorCached extends IconCreator
{
    use IconCreatorCachedServicesTrait;

    /**
     * Setup the object instance
     *
     * @param IconFamilyRepository   $iconFamilyRepo
     * @param EngineInterface        $engine
     */
    public function __construct(IconFamilyRepository $iconFamilyRepo, EngineInterface $engine = null)
    {
        parent::__construct($iconFamilyRepo, $engine);
    }

    /**
     * Render the requested icon
     *
     * @param  string|null $icon
     * @param  string|null $family
     * @param  string|null $template
     * @param  string[]    $styles
     * @return string
     * @throws IconException
     */
    public function render($icon = null, $family = null, $template = null, ...$styles)
    {
        $this->setCurrentStateAndCacheKey($icon, $family, $template, ...$styles);

        if (null === ($renderedHtml = $this->getCacheHandlerChain()->get())) {
            $renderedHtml = parent::render($icon, $family, $template, ...$styles);
            $this->getCacheHandlerChain()->set($renderedHtml);
        }

        $this->resetState();

        return $renderedHtml;
    }

    /**
     * Serializes current context into md5 hash 
     *
     * @param  string|null $icon
     * @param  string|null $family
     * @param  string|null $template
     * @param  string[]    $styles
     * @return $this
     */
    protected function setCurrentStateAndCacheKey($icon, $family, $template, ...$styles)
    {
        if ($family !== null) {
            $this->validateFamily($family);
        }

        $this
             ->checkAndSetSlug($icon,     'setIconSlug')
             ->checkAndSetSlug($template, 'setTemplateSlug')
             ->checkAndSetStyles(...$styles)
        ;

        $this->getCacheHandlerChain()->setKey(...$this->getCachableProperties());

        return $this;
    }

    /**
     * Checks if slug value given and sets relevant property if so
     *
     * @param  string|null $slugVal
     * @param  string      $slugSetter
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
     * @param  ...string $styles
     * @return $this
     */
    protected function checkAndSetStyles(...$styles)
    {
        if (true === (count($styles) > 0)) {
            $this->setStyles(...$styles);
        }

        return $this;
    }

    /**
     * Iterates available object variables and returns an array of the cachable
     * attributes applicable.
     *
     * @return mixed[]
     */
    protected function getCachableProperties()
    {
        $keyValues = [ ];
        foreach(get_object_vars($this) as $property => $value) {
            $keyValues[ ] = $property;
            $keyValues[ ] = $this->getCachablePropertyValue($value);
        }

        return $keyValues;
    }

    /**
     * Determines whether property should be cached (i.e., slugs)
     *
     * @param  mixed $value
     * @return bool
     */
    protected function getCachablePropertyValue($value)
    {
        if ($value instanceof HandlerChainInterface) {
            return 'handlerChainInstance';
        } elseif ($value instanceof EntityRepository) {
            return 'entityRepository';
        }

        return $value;
    }
}

/* EOF */
