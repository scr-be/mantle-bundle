<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Meta;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\HasTitle;
use Scribe\MantleBundle\Doctrine\Base\Model\HasLocale;
use Scribe\MantleBundle\Doctrine\Entity\State\RuntimeAction;
use Scribe\MantleBundle\Doctrine\Entity\State\RuntimeBundle;
use Scribe\MantleBundle\Doctrine\Entity\State\RuntimeController;

/**
 * Class Locale;
 */
class MetaTitle extends AbstractEntity
{
    use HasTitle;
    use HasLocale;

    /**
     * @var RuntimeBundle
     */
    protected $bundle;

    /**
     * @var RuntimeController
     */
    protected $controller;

    /**
     * @var RuntimeAction
     */
    protected $action;

    /**
     * @return $this
     */
    public function initializeBundle()
    {
        $this->bundle = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeController()
    {
        $this->controller = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeAction()
    {
        $this->controller = null;

        return $this;
    }

    /**
     * @param  RuntimeBundle $bundle
     *
     * @return $this
     */
    public function setBundle(RuntimeBundle $bundle)
    {
        $this->bundle = $bundle;

        return $this;
    }

    /**
     * @return RuntimeBundle|null
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @return bool
     */
    public function hasBundle()
    {
        return (bool) ($this->bundle !== null);
    }

    /**
     * @param  RuntimeController $controller
     *
     * @return $this
     */
    public function setController(RuntimeController $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return RuntimeController|null
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return bool
     */
    public function hasController()
    {
        return (bool) ($this->controller !== null);
    }

    /**
     * @param  RuntimeAction $action
     * @return $this
     */
    public function setAction(RuntimeAction $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return RuntimeAction|null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return bool
     */
    public function hasAction()
    {
        return (bool) ($this->action !== null);
    }
}

/* EOF */
