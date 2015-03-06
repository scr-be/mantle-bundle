<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Scribe\MantleBundle\Entity\NavMenuItem;
use Scribe\MantleBundle\Entity\NavMenuSubItem;

/**
 * NavigationItemsData
 * doctrine fixture to load data using its respective entity
 */
class NavigationItemsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $nav = [];

        // security system menus
        $context       = '__security';

        $nav[$context][0] = new NavMenuItem;
        $nav[$context][0]
            ->setContext($context)
            ->setTitle('Sign In')
            ->setRouteName('security_dashboard')
            ->setIcon('fa-sign-in')
            ->setWeight(0)
            ->setReverseRoleRestrictions(
                [
                    'IS_AUTHENTICATED_REMEMBERED'
                ]
            )
        ;

        $nav[$context][1] = new NavMenuItem;
        $nav[$context][1]
            ->setContext($context)
            ->setTitle('%User.FirstName%')
            ->setRouteName('security_dashboard')
            ->setIcon('fa-user')
            ->setWeight(1)
            ->setRoleRestrictions(
                [
                    'IS_AUTHENTICATED_REMEMBERED'
                ]
            )
        ;

        $nav[$context][2] = new NavMenuSubItem;
        $nav[$context][2]
            ->setTitle('%User.FullName%')
            ->setWeight(1)
            ->setHeader(1)
            ->setParent($nav[$context][1])
        ;

        $nav[$context][3] = new NavMenuSubItem;
        $nav[$context][3]
            ->setTitle('Dashboard')
            ->setRouteName('security_dashboard')
            ->setIcon('fa-dashboard')
            ->setWeight(2)
            ->setParent($nav[$context][1])
        ;

        $nav[$context][4] = new NavMenuSubItem;
        $nav[$context][4]
            ->setTitle('Edit Profile')
            ->setRouteName('security_profile')
            ->setIcon('fa-pencil')
            ->setWeight(3)
            ->setParent($nav[$context][1])
        ;

        $nav[$context][5] = new NavMenuSubItem;
        $nav[$context][5]
            ->setTitle('%Org.Name%')
            ->setWeight(10)
            ->setHeader(1)
            ->setParent($nav[$context][1])
        ;

        $nav[$context][6] = new NavMenuSubItem;
        $nav[$context][6]
            ->setTitle('View')
            ->setRouteName('security_organizations_view')
            ->setIcon('fa-user')
            ->setWeight(11)
            ->setParent($nav[$context][1])
            ->setRouteParameters(
                [
                    'id' => '%Org.Id%'
                ]
            )
        ;

        $nav[$context][7] = new NavMenuSubItem;
        $nav[$context][7]
            ->setTitle('Users')
            ->setRouteName('security_users_list')
            ->setIcon('fa-users')
            ->setWeight(12)
            ->setParent($nav[$context][1])
            ->setRouteParameters(
                [
                    'orgid' => '%Org.Id%'
                ]
            )
            ->setRoleRestrictions(
                [
                    'IS_ORG_MANAGER'
                ]
            )
        ;

        $nav[$context][8] = new NavMenuSubItem;
        $nav[$context][8]
            ->setTitle('Administration')
            ->setWeight(20)
            ->setHeader(1)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][9] = new NavMenuSubItem;
        $nav[$context][9]
            ->setTitle('Organizations')
            ->setRouteName('security_organizations_list')
            ->setIcon('fa-book')
            ->setWeight(21)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][10] = new NavMenuSubItem;
        $nav[$context][10]
            ->setTitle('Users')
            ->setRouteName('security_users_list')
            ->setIcon('fa-group')
            ->setWeight(22)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][11] = new NavMenuSubItem;
        $nav[$context][11]
            ->setTitle('Roles')
            ->setRouteName('security_roles_list')
            ->setIcon('fa-tag')
            ->setWeight(23)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][12] = new NavMenuSubItem;
        $nav[$context][12]
            ->setTitle('Session')
            ->setWeight(30)
            ->setHeader(1)
            ->setParent($nav[$context][1])
        ;

        $nav[$context][13] = new NavMenuSubItem;
        $nav[$context][13]
            ->setTitle('Switch Back')
            ->setRouteName('security_switch_user_exit')
            ->setIcon('fa-sign-out')
            ->setWeight(31)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_PREVIOUS_ADMIN'
                ]
            )
        ;

        $nav[$context][14] = new NavMenuSubItem;
        $nav[$context][14]
            ->setTitle('Switch User')
            ->setRouteName('security_switch_user_redirect')
            ->setIcon('fa-exchange')
            ->setWeight(32)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_ALLOWED_TO_SWITCH'
                ]
            )
            ->setReverseRoleRestrictions(
                [
                    'ROLE_PREVIOUS_ADMIN'
                ]
            )
        ;

        $nav[$context][15] = new NavMenuSubItem;
        $nav[$context][15]
            ->setTitle('Sign Out')
            ->setRouteName('logout')
            ->setIcon('fa-sign-out')
            ->setWeight(33)
            ->setParent($nav[$context][1])
            ->setReverseRoleRestrictions(
                [
                    'ROLE_PREVIOUS_ADMIN'
                ]
            )
        ;

        // services menus
        $context = '__services';

        $nav[$context][0] = new NavMenuItem;
        $nav[$context][0]
            ->setContext($context)
            ->setTitle('Accounts')
            ->setRouteName('security_dashboard')
            ->setIcon('fa-lock')
            ->setWeight(0)
        ;

        $nav[$context][1] = new NavMenuItem;
        $nav[$context][1]
            ->setContext($context)
            ->setTitle('Blog')
            ->setRouteName('scribe_blog_index')
            ->setIcon('fa-rss')
            ->setWeight(1)
        ;

        $nav[$context][2] = new NavMenuItem;
        $nav[$context][2]
            ->setContext($context)
            ->setTitle('Digital Hub')
            ->setRouteName(null)
            ->setIcon('fa-print')
            ->setWeight(2)
        ;

        $nav[$context][3] = new NavMenuItem;
        $nav[$context][3]
            ->setContext($context)
            ->setTitle('Status')
            ->setRouteName('scribe_status_index')
            ->setIcon('fa-tachometer')
            ->setWeight(3)
        ;

        // blog menu items
        $context = 'blog';

        $nav[$context][0] = new NavMenuItem;
        $nav[$context][0]
            ->setContext($context)
            ->setTitle('Book')
            ->setRouteName('scribe_book_list')
            ->setWeight(0)
        ;

        $nav[$context][1] = new NavMenuItem;
        $nav[$context][1]
            ->setContext($context)
            ->setTitle('Blog')
            ->setRouteName('scribe_blog_list')
            ->setWeight(1)
        ;

        $nav[$context][2] = new NavMenuItem;
        $nav[$context][2]
            ->setContext($context)
            ->setTitle('E-book Project')
            ->setRouteName('scribe_ebp_index')
            ->setWeight(2)
        ;

        $nav[$context][100] = new NavMenuItem;
        $nav[$context][100]
            ->setContext($context)
            ->setTitle('Admin')
            ->setWeight(100)
            ->setRoleRestrictions(
                [
                    'ROLE_STATUS_ADMIN'
                ]
            )
        ;

        $nav[$context][101] = new NavMenuSubItem;
        $nav[$context][101]
            ->setTitle('Blog')
            ->setWeight(101)
            ->setHeader(1)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][102] = new NavMenuSubItem;
        $nav[$context][102]
            ->setTitle('Add Entry')
            ->setRouteName('scribe_blog_add')
            ->setIcon('fa-plus')
            ->setWeight(102)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][103] = new NavMenuSubItem;
        $nav[$context][103]
            ->setTitle('Blog Author')
            ->setWeight(103)
            ->setHeader(1)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][104] = new NavMenuSubItem;
        $nav[$context][104]
            ->setTitle('Add Author')
            ->setRouteName('scribe_blog_author_add')
            ->setIcon('fa-plus')
            ->setWeight(104)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][105] = new NavMenuSubItem;
        $nav[$context][105]
            ->setTitle('List Authors')
            ->setRouteName('scribe_blog_author_list')
            ->setIcon('fa-bars')
            ->setWeight(105)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][106] = new NavMenuSubItem;
        $nav[$context][106]
            ->setTitle('Book')
            ->setWeight(106)
            ->setHeader(1)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][107] = new NavMenuSubItem;
        $nav[$context][107]
            ->setTitle('Add Chapter')
            ->setRouteName('scribe_book_ch_add')
            ->setIcon('fa-plus')
            ->setWeight(107)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][108] = new NavMenuSubItem;
        $nav[$context][108]
            ->setTitle('E-book Enhancement')
            ->setWeight(108)
            ->setHeader(1)
            ->setParent($nav[$context][100])
        ;

        $nav[$context][109] = new NavMenuSubItem;
        $nav[$context][109]
            ->setTitle('Add Section')
            ->setRouteName('scribe_ebp_add')
            ->setIcon('fa-plus')
            ->setWeight(109)
            ->setParent($nav[$context][100])
        ;

        // security menu items
        $context = 'security';

        $nav[$context][0] = new NavMenuItem;
        $nav[$context][0]
            ->setContext($context)
            ->setTitle('Dashboard')
            ->setRouteName('security_dashboard')
            ->setWeight(0)
        ;

        $nav[$context][1] = new NavMenuItem;
        $nav[$context][1]
            ->setContext($context)
            ->setTitle('User')
            ->setWeight(1)
            ->setRoleRestrictions(
                [
                    'IS_AUTHENTICATED_REMEMBERED'
                ]
            )
        ;

        $nav[$context][101] = new NavMenuSubItem;
        $nav[$context][101]
            ->setTitle('%User.FullName%')
            ->setWeight(1)
            ->setHeader(1)
            ->setParent($nav[$context][1])
        ;

        $nav[$context][102] = new NavMenuSubItem;
        $nav[$context][102]
            ->setTitle('View')
            ->setRouteName('security_users_view')
            ->setIcon('fa-user')
            ->setWeight(2)
            ->setParent($nav[$context][1])
            ->setRouteParameters(
                [
                    'id' => '%User.Id%'
                ]
            )
        ;

        $nav[$context][103] = new NavMenuSubItem;
        $nav[$context][103]
            ->setTitle('Edit')
            ->setRouteName('security_users_edit')
            ->setIcon('fa-pencil')
            ->setWeight(3)
            ->setParent($nav[$context][1])
            ->setRouteParameters(
                [
                    'id' => '%User.Id%'
                ]
            )
        ;

        $nav[$context][104] = new NavMenuSubItem;
        $nav[$context][104]
            ->setTitle('%Org.Name%')
            ->setWeight(10)
            ->setHeader(1)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'IS_ORG_MANAGER'
                ]
            )
        ;

        $nav[$context][105] = new NavMenuSubItem;
        $nav[$context][105]
            ->setTitle('List')
            ->setRouteName('security_users_list')
            ->setIcon('fa-bars')
            ->setWeight(11)
            ->setParent($nav[$context][1])
            ->setRouteParameters(
                [
                    'orgid' => '%Org.Id%'
                ]
            )
            ->setRoleRestrictions(
                [
                    'IS_ORG_MANAGER'
                ]
            )
        ;

        $nav[$context][106] = new NavMenuSubItem;
        $nav[$context][106]
            ->setTitle('Create')
            ->setRouteName('security_users_create')
            ->setIcon('fa-plus')
            ->setWeight(12)
            ->setParent($nav[$context][1])
            ->setRouteParameters(
                [
                    'orgid' => '%Org.Id%'
                ]
            )
            ->setRoleRestrictions(
                [
                    'IS_ORG_MANAGER'
                ]
            )
        ;

        $nav[$context][107] = new NavMenuSubItem;
        $nav[$context][107]
            ->setTitle('Administration')
            ->setWeight(20)
            ->setHeader(1)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][108] = new NavMenuSubItem;
        $nav[$context][108]
            ->setTitle('List')
            ->setRouteName('security_users_list')
            ->setIcon('fa-bars')
            ->setWeight(21)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][109] = new NavMenuSubItem;
        $nav[$context][109]
            ->setTitle('Create')
            ->setRouteName('security_users_create')
            ->setIcon('fa-plus')
            ->setWeight(22)
            ->setParent($nav[$context][1])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][2] = new NavMenuItem;
        $nav[$context][2]
            ->setContext($context)
            ->setTitle('Organization')
            ->setWeight(2)
            ->setRoleRestrictions(
                [
                    'IS_AUTHENTICATED_REMEMBERED'
                ]
            )
        ;

        $nav[$context][201] = new NavMenuSubItem;
        $nav[$context][201]
            ->setTitle('%Org.Name%')
            ->setWeight(1)
            ->setHeader(1)
            ->setParent($nav[$context][2])
        ;

        $nav[$context][202] = new NavMenuSubItem;
        $nav[$context][202]
            ->setTitle('View')
            ->setRouteName('security_organizations_view')
            ->setIcon('fa-book')
            ->setWeight(2)
            ->setParent($nav[$context][2])
            ->setRouteParameters(
                [
                    'id' => '%Org.Id%'
                ]
            )
        ;

        $nav[$context][203] = new NavMenuSubItem;
        $nav[$context][203]
            ->setTitle('Edit')
            ->setRouteName('security_organizations_edit')
            ->setIcon('fa-pencil')
            ->setWeight(3)
            ->setParent($nav[$context][2])
            ->setRouteParameters(
                [
                    'id' => '%Org.Id%'
                ]
            )
            ->setRoleRestrictions(
                [
                    'IS_ORG_MANAGER'
                ]
            )
        ;

        $nav[$context][204] = new NavMenuSubItem;
        $nav[$context][204]
            ->setTitle('Administration')
            ->setWeight(10)
            ->setHeader(1)
            ->setParent($nav[$context][2])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][205] = new NavMenuSubItem;
        $nav[$context][205]
            ->setTitle('List')
            ->setRouteName('security_organizations_list')
            ->setIcon('fa-bars')
            ->setWeight(11)
            ->setParent($nav[$context][2])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][206] = new NavMenuSubItem;
        $nav[$context][206]
            ->setTitle('Create')
            ->setRouteName('security_organizations_create')
            ->setIcon('fa-plus')
            ->setWeight(12)
            ->setParent($nav[$context][2])
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][3] = new NavMenuItem;
        $nav[$context][3]
            ->setContext($context)
            ->setTitle('Role')
            ->setWeight(3)
            ->setRoleRestrictions(
                [
                    'ROLE_SECURITY_ADMIN'
                ]
            )
        ;

        $nav[$context][301] = new NavMenuSubItem;
        $nav[$context][301]
            ->setTitle('List')
            ->setRouteName('security_roles_list')
            ->setIcon('fa-bars')
            ->setWeight(1)
            ->setParent($nav[$context][3])
        ;

        $nav[$context][302] = new NavMenuSubItem;
        $nav[$context][302]
            ->setTitle('Create')
            ->setRouteName('security_roles_create')
            ->setIcon('fa-plus')
            ->setWeight(2)
            ->setParent($nav[$context][3])
        ;

        // status menu items
        $context = 'status';

        $nav[$context][0] = new NavMenuItem;
        $nav[$context][0]
            ->setContext($context)
            ->setTitle('Dashboard')
            ->setRouteName('scribe_status_dashboard')
            ->setWeight(0)
        ;

        $nav[$context][1] = new NavMenuItem;
        $nav[$context][1]
            ->setContext($context)
            ->setTitle('Systems')
            ->setRouteName('scribe_status_systems')
            ->setWeight(1)
        ;

        $nav[$context][2] = new NavMenuItem;
        $nav[$context][2]
            ->setContext($context)
            ->setTitle('Reports')
            ->setRouteName('scribe_status_issues')
            ->setWeight(2)
        ;

        $nav[$context][3] = new NavMenuItem;
        $nav[$context][3]
            ->setContext($context)
            ->setTitle('Notices')
            ->setRouteName('scribe_status_notices')
            ->setWeight(3)
        ;

        $nav[$context][4] = new NavMenuItem;
        $nav[$context][4]
            ->setContext($context)
            ->setTitle('Logs')
            ->setWeight(4)
            ->setRoleRestrictions(
                [
                    'ROLE_STATUS_ADMIN'
                ]
            )
        ;

        $nav[$context][401] = new NavMenuSubItem;
        $nav[$context][401]
            ->setTitle('System Logs')
            ->setWeight(1)
            ->setHeader(1)
            ->setParent($nav[$context][4])
        ;

        $nav[$context][402] = new NavMenuSubItem;
        $nav[$context][402]
            ->setTitle('List All')
            ->setRouteName('status_syslog_list')
            ->setIcon('fa-bars')
            ->setWeight(2)
            ->setParent($nav[$context][4])
        ;

        $nav[$context][403] = new NavMenuSubItem;
        $nav[$context][403]
            ->setTitle('Search')
            ->setRouteName('status_syslog_search')
            ->setIcon('fa-search')
            ->setWeight(3)
            ->setParent($nav[$context][4])
        ;

        $nav[$context][404] = new NavMenuSubItem;
        $nav[$context][404]
            ->setTitle('Firewall Logs')
            ->setWeight(10)
            ->setHeader(1)
            ->setParent($nav[$context][4])
        ;

        $nav[$context][405] = new NavMenuSubItem;
        $nav[$context][405]
            ->setTitle('List All')
            ->setRouteName('status_firewall_list')
            ->setIcon('fa-bars')
            ->setWeight(11)
            ->setParent($nav[$context][4])
        ;

        $nav[$context][406] = new NavMenuSubItem;
        $nav[$context][406]
            ->setTitle('Filter by IP')
            ->setRouteName('status_firewall_byip')
            ->setIcon('fa-filter')
            ->setWeight(12)
            ->setParent($nav[$context][4])
        ;

        $nav[$context][5] = new NavMenuItem;
        $nav[$context][5]
            ->setContext($context)
            ->setTitle('Admin')
            ->setWeight(5)
            ->setRoleRestrictions(
                [
                    'ROLE_STATUS_ADMIN'
                ]
            )
        ;

        $nav[$context][501] = new NavMenuSubItem;
        $nav[$context][501]
            ->setTitle('Systems')
            ->setWeight(1)
            ->setHeader(1)
            ->setParent($nav[$context][5])
        ;

        $nav[$context][502] = new NavMenuSubItem;
        $nav[$context][502]
            ->setTitle('Create')
            ->setRouteName('status_systems_add')
            ->setIcon('fa-plus')
            ->setWeight(2)
            ->setParent($nav[$context][5])
        ;

        $nav[$context][503] = new NavMenuSubItem;
        $nav[$context][503]
            ->setTitle('Reports')
            ->setWeight(10)
            ->setHeader(1)
            ->setParent($nav[$context][5])
        ;

        $nav[$context][504] = new NavMenuSubItem;
        $nav[$context][504]
            ->setTitle('Create')
            ->setRouteName('status_issues_add')
            ->setIcon('fa-plus')
            ->setWeight(11)
            ->setParent($nav[$context][5])
        ;

        $nav[$context][505] = new NavMenuSubItem;
        $nav[$context][505]
            ->setTitle('Notices')
            ->setWeight(20)
            ->setHeader(1)
            ->setParent($nav[$context][5])
        ;

        $nav[$context][506] = new NavMenuSubItem;
        $nav[$context][506]
            ->setTitle('Create')
            ->setRouteName('status_notices_add')
            ->setIcon('fa-plus')
            ->setWeight(21)
            ->setParent($nav[$context][5])
        ;

        // add everything
        foreach ($nav as $navContext) {
            foreach ($navContext as $navItem) {
                $manager->persist($navItem);
            }
        }

        // flush entity manager to db
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1001;
    }
}

/* EOF */
