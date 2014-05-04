<?php
namespace Volleyball\Bundle\UtilityBundle\Menu;

use Symfony\Component\HttpFoundation\Request;

use Volleyball\Bundle\UtilityBundle\Menu\BaseBuilder;

class LeaderMenuBuilder extends BaseBuilder
{
    /**
     * @param Request $request
     * @return menuItem
     */
    public function createLeaderMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $menu->addChild(
            'home',
            array('route' => 'homepage')
        );

        $menu->addChild($this->activeEnrollmentMenu($request));
        
        $menu->addChild($this->passelManagementMenu($request));
        
        $menu->addChild($this->courseMenu($request));
        
        $menu->addChild($this->facilityMenu($request));
        
        $this->addChild($this->reportMenu($request));
        
        $this->addChild($this->profileMenu($request));
        
        return $menu;
    }
    
    /**
     * @param Request $request
     * @return menuItem
     */
    public function passelManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('passel management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        // if admin, show attendee menu
        if ($this->securityContext->isGranted('ROLE_PASSEL_ADMIN')) {
            $menu->addChild('attendees')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa-group');
            
            $menu['attendees']->addChild(
                'list attendees',
                array(
                    'route' => 'volleyball_attendee_index_by_passel',
                    'routeParameter' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getPassel()->getSlug()
                    )
                )
            );
            
            $menu['attendees']->addChild(
                'add an attendee',
                array(
                    'route' => 'volleyball_attendee_new'
                )
            );
        } else { // else show menu item
            $menu->addChild(
                'attendees',
                array(
                    'route' => 'volleyball_attendee_index_by_passel',
                    'routeParameters' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getPassel()->getSlug()
                    )
                )
            );
        }

        // if admin, show faction menu
        if ($this->securityContext->isGranted('ROLE_PASSEL_ADMIN')) {
            $menu->addChild('factions')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa-group');
            
            $menu['factions']->addChild(
                'list factions',
                array(
                    'route' => 'volleyball_faction_index_by_passel',
                    'routeParameter' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getPassel()->getSlug()
                    )
                )
            );
            
            $menu['factions']->addChild(
                'add a faction',
                array(
                    'route' => 'volleyball_faction_new'
                )
            );
        } else { // else show menu item
            $menu->addChild(
                'factions',
                array(
                    'route' => 'volleyball_faction_index_by_passel',
                    'routeParameters' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getPassel()->getSlug()
                    )
                )
            );
        }
        
        // if admin, show leader menu
        if ($this->securityContext->isGranted('ROLE_PASSEL_ADMIN')) {
            $menu->addChild('leaders')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa-group');
            
            $menu['leaders']->addChild(
                'list leaders',
                array(
                    'route' => 'volleyball_leader_index_by_passel',
                    'routeParameter' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getPassel()->getSlug()
                    )
                )
            );
            
            $menu['leaders']->addChild(
                'add a leader',
                array(
                    'route' => 'volleyball_leader_new'
                )
            );
        } else { // else show menu item
            $menu->addChild(
                'leaders',
                array(
                    'route' => 'volleyball_leader_index_by_passel',
                    'routeParameters' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getPassel()->getSlug()
                    )
                )
            );
        }
        
        return $menu;
    }
}
