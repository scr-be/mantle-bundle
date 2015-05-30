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

use Scribe\CacheBundle\Cache\Handler\Chain\CacheChainInterface;
use Twig_Environment;
use Doctrine\ORM\EntityRepository;
use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChainInterface;
use Scribe\MantleBundle\Doctrine\Repository\Icon\IconFamilyRepository;
use Scribe\MantleBundle\Templating\Generator\Icon\Model\IconCreatorCachedServicesTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException;

/**
 * Class: IconCreatorCached.
 */
class IconCreatorCached extends IconCreator
{
    use IconCreatorCachedServicesTrait;

    /**
     * Setup the object instance.
     *
     * @param IconFamilyRepository $iconFamilyRepo
     * @param Twig_Environment     $engineEnvironment
     */
    public function __construct(IconFamilyRepository $iconFamilyRepo, Twig_Environment $engineEnvironment = null)
    {
        parent::__construct($iconFamilyRepo, $engineEnvironment);
    }

    /**
     * Render the requested icon.
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string|null $template
     * @param string[]    $styles
     *
     * @return string
     *
     * @throws IconCreatorException
     */
    public function render($icon = null, $family = null, $template = null, ...$styles)
    {
        $this->setCurrentStateAndCacheKey($icon, $family, $template, ...$styles);

        if (null === ($renderedHtml = $this->getCacheChain()->get())) {
            $renderedHtml = parent::render($icon, $family, $template, ...$styles);
            $this->getCacheChain()->set($renderedHtml);
        }

        $this->resetState();

        return $renderedHtml;
    }

    /**
     * Serializes current context into md5 hash.
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string|null $template
     * @param string[]    $styles
     *
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

        $this->getCacheChain()->setKey(...$this->getCachableProperties());

        return $this;
    }

    /**
     * Checks if slug value given and sets relevant property if so.
     *
     * @param string|null $slugVal
     * @param string      $slugSetter
     *
     * @return $this
     */
    protected function checkAndSetSlug($slugVal, $slugSetter)
    {
        if (null !== $slugVal) {
            $this->{$slugSetter}($slugVal);
        }

        return $this;
    }

    /**
     * Checks if styles values given and sets relevant property if so.
     *
     * @param ...string $styles
     *
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
        $keyValues = [];
        foreach (get_object_vars($this) as $property => $value) {
            $keyValues[ ] = $property;
            $keyValues[ ] = $this->getCachablePropertyValue($value);
        }

        return $keyValues;
    }

    /**
     * Determines whether property should be cached (i.e., slugs).
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function getCachablePropertyValue($value)
    {
        if ($value instanceof CacheChainInterface) {
            return 'handlerChainInstance';
        } elseif ($value instanceof EntityRepository) {
            return 'entityRepository';
        }

        return $value;
    }
}

/* EOF */
