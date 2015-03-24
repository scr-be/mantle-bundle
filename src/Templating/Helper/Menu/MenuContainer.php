<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Helper\Menu;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class Menu.
 */
class MenuContainer
{
    /**
     * @var EngineInterface|null
     */
    private $engine = null;

    /**
     * @var EntityManager|null
     */
    private $em = null;

    /**
     * @var array
     */
    private $menuHeader = [];

    /**
     * @var array
     */
    private $menuSecurity = [];

    /**
     * @var array
     */
    private $menuServices = [];

    /**
     * @var array
     */
    private $menuFooter = [];

    /**
     * @var array
     */
    private $settings = [];

    /**
     */
    public function __construct(EngineInterface $engine = null, EntityManager $em = null)
    {
        $this->engine = $engine;
        $this->em     = $em;
    }

    public function setMenuHeader(array $items = array())
    {
        $this->menuHeader = $items;

        return $this;
    }

    public function setMenuSecurity(array $items = array())
    {
        $this->menuSecurity = $items;

        return $this;
    }

    public function setMenuServices(array $items = array())
    {
        $this->menuServices = $items;

        return $this;
    }

    public function setMenuFooter(array $items = array())
    {
        $this->menuFooter = $items;

        return $this;
    }

    public function setMenuSettings(array $settings = array())
    {
        foreach ($settings as $s) {
            $this->settings[$s->getK()] = $s->getV();
        }

        return $this;
    }

    public function renderHeader()
    {
        return $this->engine->render(
            'ScribePublicBundle:Menu:main.html.twig',
            [
                'main'     => $this->menuHeader,
                'security' => $this->menuSecurity,
                'services' => $this->menuServices,
                'settings' => $this->settings,
            ]
        );
    }

    public function renderFooter()
    {
        $entries = $this->em
            ->getRepository('ScribeBlogBundle:BlogEntry')
            ->loadLatest(3)
        ;

        return $this->engine->render(
            'ScribePublicBundle:Menu:foot.html.twig',
            [
                'foot'     => $this->menuFooter,
                'entries'  => $entries,
                'settings' => $this->settings,
            ]
        );
    }
}
