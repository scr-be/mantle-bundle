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

use Scribe\CacheBundle\Component\Manager\CacheManagerInterface;
use Scribe\MantleBundle\Doctrine\Repository\Icon\IconRepository;
use Twig_Environment;
use Doctrine\ORM\EntityRepository;
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
     * Allows to check the accessor {@see $this->isCachedResult()} and see if icon came from the cache or not.
     *
     * @var bool
     */
    protected $cachedResult = false;

    /**
     * @param IconFamilyRepository  $iconFamilyRepo
     * @param IconRepository        $iconRepo
     * @param Twig_Environment|null $engineEnvironment
     */
    public function __construct(IconFamilyRepository $iconFamilyRepo, IconRepository $iconRepo, Twig_Environment $engineEnvironment = null)
    {
        parent::__construct($iconFamilyRepo, $iconRepo, $engineEnvironment);
    }

    /**
     * Updated on render, allowing you to check if you received a cached result.
     *
     * @return bool
     */
    public function isCachedResult()
    {
        return (bool) $this->cachedResult;
    }

    /**
     * Render the requested icon.
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string[]    $styles
     *
     * @return string
     *
     * @throws IconCreatorException
     */
    public function render($icon = null, $family = null, ...$styles)
    {
        $this->setCurrentStateAndCacheKey($icon, $family, ...$styles);
        $this->cachedResult = true;

        if (null === ($renderedHtml = $this->getCache()->get())) {
            $this->cachedResult = false;
            $renderedHtml = parent::render($icon, $family, ...$styles);

            $this->getCache()->set($renderedHtml);
        }

        $this->resetState();

        return $renderedHtml;
    }

    /**
     * Serializes current context into md5 hash.
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string[]    $styles
     *
     * @return $this
     */
    protected function setCurrentStateAndCacheKey($icon, $family, ...$styles)
    {
        if ($family !== null) {
            $this->setIconFamilySlug($family);
        }

        if ($icon !== null) {
            $this->setIconSlug($icon);
        }

        if (count($styles) > 0) {
            $this->setStyles(...$styles);
        }

        $this
            ->getCache()
            ->setKey(...$this->getCachableProperties())
        ;

        return $this;
    }

    /**
     * Iterates available object variables and returns an array of the cachable attributes applicable.
     *
     * @return mixed[]
     */
    protected function getCachableProperties()
    {
        $cacheKeyCollection = [];

        foreach (get_object_vars($this) as $name => $value) {
            $cacheKeyCollection[][$name] = $this->getCachablePropertyValue($name, $value);
        }

        return $cacheKeyCollection;
    }

    /**
     * Determines whether property should be cached (i.e., slugs).
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    protected function getCachablePropertyValue($name, $value)
    {
        if ($name === 'cachedResult') {
            return 'isCachedProperty';
        }

        if ($value instanceof CacheManagerInterface) {
            return 'handlerChainInstance';
        }

        if ($value instanceof EntityRepository) {
            return 'entityRepository';
        }

        return $value;
    }
}

/* EOF */
