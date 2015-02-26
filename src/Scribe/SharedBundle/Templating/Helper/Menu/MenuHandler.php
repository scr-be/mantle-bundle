<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Helper\Menu;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Scribe\Component\Bundle\BundleInformation;
use Scribe\SharedBundle\Entity\NavMenuItem;
use Scribe\SharedBundle\Entity\NavMenuItemRepository;
use Scribe\SharedBundle\Entity\NavMenuSettingRepository;

/**
 * Class MenuHandler
 */
class MenuHandler implements MenuHandlerInterface, ContainerAwareInterface
{
    /**
     * the security menu db context
     */
    const MENU_CONTEXT_SECURITY = '__security';

    /**
     * the services menu db context
     */
    const MENU_CONTEXT_SERVICES = '__services';

    /**
     * the footer menu db context
     */
    const MENU_CONTEXT_FOOTER = '__footer';

    /**
     * @var ContainerInterface|null
     */
    private $container = null;

    /**
     * @var NavMenuItemRepository
     */
    private $navMenuItemRepo;

    /**
     * @var NavMenuSettingRepository
     */
    private $navMenuSettingRepo;

    /**
     * @var BundleInformation
     */
    private $bundleInformation;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @param ContainerInterface|null $container
     */
    public function __construct(
        ContainerInterface       $container = null,
        NavMenuItemRepository    $navMenuItemRepo = null,
        NavMenuSettingRepository $navMenuSettingRepo = null,
        BundleInformation        $bundleInformation = null,
        SecurityContext          $securityContext = null)
    {
        $this->setContainer($container);

        $this->navMenuItemRepo    = $navMenuItemRepo;
        $this->navMenuSettingRepo = $navMenuSettingRepo;
        $this->bundleInformation  = $bundleInformation;
        $this->securityContext    = $securityContext;
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return void
     */
    public function getMenus()
    {
        return [
            $this->initSecurityMenu(),
            $this->initServicesMenu(),
            $this->initMainMenu(),
            $this->initFooterMenu(),
            $this->initMainMenuSettings(),
        ];
    }

    /**
     * @return array
     */
    private function initSecurityMenu()
    {
        return $this->initMenu(self::MENU_CONTEXT_SECURITY);
    }

    /**
     * @return array
     */
    private function initServicesMenu()
    {
        return $this->initMenu(self::MENU_CONTEXT_SERVICES);
    }

    /**
     * @return array
     */
    private function initMainMenu()
    {
        return $this->initMenuFull(
            $this->bundleInformation->getBundle(),
            $this->bundleInformation->getBundle().'.'.$this->bundleInformation->getController(),
            $this->bundleInformation->getBundle().'.'.$this->bundleInformation->getController().'.'.$this->bundleInformation->getAction()
        );
    }

    /**
     * @return array
     */
    private function initMainMenuSettings()
    {
        return $this
            ->navMenuSettingRepo
            ->findByContext($this->bundleInformation->getBundle())
        ;
    }

    /**
     * @return array
     */
    private function initFooterMenu()
    {
        return $this->initMenu(self::MENU_CONTEXT_FOOTER);
    }

    /**
     * @param  string $context
     * @return array
     */
    private function initMenu($context = null)
    {
        $entities  = $this->getMenuEntities($context);
        $menuItems = $this->getMenuItems($entities);

        return $menuItems;
    }

    /**
     * @param  string $context
     * @return array
     */
    private function getMenuEntities($context = null)
    {
        return $this
            ->navMenuItemRepo
            ->findByContextOrderByWeight($context)
        ;
    }

    /**
     * @param  null|string $contextBundle
     * @param  null|string $contextController
     * @param  null|string $contextAction
     * @return array
     */
    private function initMenuFull($contextBundle = null, $contextController = null, $contextAction = null)
    {
        $entities  = $this->getMenuFullEntities($contextBundle, $contextController, $contextAction);
        $menuItems = $this->getMenuItems($entities);

        return $menuItems;
    }

    /**
     * @param  null|string $contextBundle
     * @param  null|string $contextController
     * @param  null|string $contextAction
     * @return array
     */
    private function getMenuFullEntities($contextBundle = null, $contextController = null, $contextAction = null)
    {
        return $this
            ->navMenuItemRepo
            ->findByContextFullOrderByWeight($contextBundle, $contextController, $contextAction)
        ;
    }

    /**
     * @param  array $entities
     * @return array
     */
    private function getMenuItems(array $entities = array())
    {
        $menuItems = [];

        foreach ($entities as $e) {
            if ($this->menuItemIsAllowed($e) and $this->menuItemIsAllowedReverse($e)) {
                $menuItems[] = $this->getNewMenuItem($e);
            }
        }

        return $menuItems;
    }

    /**
     * @param  NavMenuItem|NavMenuSubItem $entity
     * @return MenuItem
     */
    private function getNewMenuItem($entity)
    {
        $routeParameters = $this->parametersParser((array)$entity->getRouteParameters());

        $item = new MenuItem($this->container);
        $item
            ->setTitle($this->titleParser($entity->getTitle()))
            ->setIcon($entity->getIcon())
            ->setRoute($entity->getRouteName(), (array)$routeParameters)
        ;

        if ($entity->isHeader()) {
            $item->setHeader(true);
        }

        if ($entity->hasSubItems()) {
            $subs = $this->getMenuItems($entity->getSubItems()->toArray());
            $item->setSubMenus($subs);
        }

        if ($entity instanceof NavMenuItem) {
            if ($entity->getAttrValue('forceActiveByBundle') !== null && $entity->getAttrValue('forceActiveByBundle') === $this->bundleInformation->getBundle()) {
                $item->setForceActive(true);
            }
        }

        return $item;
    }

    /**
     * @param  NavMenuItem|NavMenuSubItem $entity
     * @return boolean
     */
    private function menuItemIsAllowed($entity)
    {
        $restrictions = $entity->getRoleRestrictions();

        if (!count($restrictions) > 0) {
            return true;
        }

        foreach ($restrictions as $r) {
            if ($this->securityContext->isGranted($r)) {
                return true;
            }
            $user = $this->securityContext->getToken()->getUser() ?: false;
            if ($user !== false && $user !== 'anon.' && strtolower($user->getOrg()->getCode()) == strtolower($r)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  NavMenuItem|NavMenuSubItem $entity
     * @return boolean
     */
    private function menuItemIsAllowedReverse($entity)
    {
        $reversedRestrictions = $entity->getReverseRoleRestrictions();

        if (!count($reversedRestrictions) > 0) {
            return true;
        }

        foreach ($reversedRestrictions as $r) {
            if (!$this->securityContext->isGranted($r)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string $title
     * @return string
     */
    private function titleParser($title)
    {
        return $this->runParser($title);
    }

    private function parametersParser(array $parameters = array())
    {
        foreach ($parameters as $i => &$p) {
            $p = $this->runParser($p);
        }

        return $parameters;
    }

    /**
     * @param  string $string
     * @return string
     */
    private function runParser($string)
    {
        $token = $this
            ->securityContext
            ->getToken()
        ;

        if ($token === null || ($user = $token->getUser()) == 'anon.') {
            return $string;
        }

        $objects = [
            'User'  => $user,
            'Token' => $token,
            'Org'   => $user->getOrg(),
        ];

        if (preg_match('#%(.*)\.(.*)%#', $string, $matches)) {
            $original = $matches[0];
            $object   = $matches[1];
            $method   = 'get'.$matches[2];

            if (!array_key_exists($object, $objects)) {
                return $string;
            }

            if (!method_exists($objects[$object], $method)) {
                return $string;
            }

            $replace = $objects[$object]->$method();
            $string  = str_replace($original, $replace, $string);
        }

        return $string;
    }

}
