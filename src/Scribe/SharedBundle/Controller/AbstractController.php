<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Scribe\SharedBundle\Templating\Helper\Bootstrap\Menu\MenuDivider;
use Scribe\SharedBundle\Templating\Helper\Bootstrap\Menu\MenuHeader;
use Scribe\SharedBundle\Templating\Helper\Bootstrap\Menu\Menu;

/**
 * Class AbstractController
 */
abstract class AbstractController extends Controller
{
    /**
     * @param string[] $which
     * @return array
     */
    public function getServices(array $which = [])
    {
        $services = [];
        foreach ($which as $service_key) {
            $services[] = $this->getServiceSelector($service_key);
        }

        return $services;
    }

    /**
     * @param string $service_key
     * @return object
     */
    protected function getServiceSelector($service_key)
    {
        switch ($service_key) {
            case 'em':
                return $this
                    ->getDoctrine()
                    ->getManager()
                ;
            case 'request':
                return $this
                    ->container
                    ->get('request')
                ;
            case 'session':
                return $this
                    ->container
                    ->get('request')
                    ->getSession()
                ;
            case 'user':
                return $this
                    ->getUser()
                ;
            default:
                return $this
                    ->container
                    ->get($service_key)
                ;
        }
    }

    /**
     * @param string $name
     * @param null|string $route
     * @return object
     */
    protected function renderMenu($name = 'Undefined', $route = null)
    {
        list($user, $securityContext, $request) = $this->getServices(['user', 'security.context', 'request']);

        $routeName = $request->get('_route');
        $menu = $this->container->get('scribe.menu.main');
        $menu->setName($name);
        $menu->setRoute($route);

        $menuItems = [];

        try {
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') &&
                null !== ($token = $securityContext->getToken()) &&
                null !== ($user = $token->getUser())) {

                $menuItems[] = new MenuHeader('Your Account');
                $menuItems[] = new Menu('Dashboard',     'security_dashboard',     null, 'icon-dashboard');
                $menuItems[] = new Menu('Profile',       'security_profile',       null, 'icon-user');

                if ($securityContext->isGranted('ROLE_ROOT')) {
                    $menuItems[] = new MenuDivider('divider1');
                    $menuItems[] = new MenuHeader('Administer');
                    $menuItems[] = new Menu('Users',         'security_users_list',         null, 'icon-group');
                    $menuItems[] = new Menu('Organizations', 'security_organizations_list', null, 'icon-book');
                    $menuItems[] = new Menu('Settings',      'security_settings',           null, 'icon-cog');
                }
                $menuItems[] = new MenuDivider('divider2');
                $menuItems[] = new MenuHeader('Session');

                if ($securityContext->isGranted('ROLE_PREVIOUS_ADMIN')) {
                    $menuItems[] = new Menu('Switch Back', 'security_switch_user_exit', [], 'icon-signout');
                } else {
                    if ($securityContext->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
                        $menuItems[] = new Menu('Switch User', 'security_switch_user_redirect', null, 'icon-user');
                    }
                    $menuItems[] = new Menu('Logout', 'logout', null, 'icon-signout');
                }

                $menu->setSecurityName($user->getFirstName());
                $menu->setSecurityRoute('security_dashboard');
                $menu->setSecurityIcon('icon-user');
            } else {
                $menu->setSecurityName( 'Login'      );
                $menu->setSecurityRoute('login'      );
                $menu->setSecurityIcon( 'icon-signin');
            }
        }
        catch(AuthenticationCredentialsNotFoundException $e) {
            $menu->setSecurityName( 'Login'      );
            $menu->setSecurityRoute('login'      );
            $menu->setSecurityIcon( 'icon-signin');
        }

        foreach ($menuItems as $item) {
            $menu->addSecurityMenu($item);
        }

        return $menu;
    }

    /**
     * @return object
     */
    protected function renderMenuFoot()
    {
        $menu = $this->container->get('scribe.menu.foot');
        $menu->init();

        return $menu;
    }

    /**
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $menu = $this->renderMenu();
        $menu->setOther('services', $this->renderMenuFoot());

        return parent::render($view, $parameters, $response);
    }

    /**
     * @see Controller::createForm()
     * @param $name
     * @param $type
     * @param null $data
     * @param array $options
     * @return mixed
     */
    public function createNamedForm($name, $type, $data = null, array $options = array())
    {
        return $this->container->get('form.factory')->createNamed($name, $type, $data, $options);
    }
}
