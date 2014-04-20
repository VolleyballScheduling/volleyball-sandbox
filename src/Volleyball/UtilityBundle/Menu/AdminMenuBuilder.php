<?php
namespace Volleyball\UtilityBundle\Menu;

use Volleyball\UtilityBundle\Menu\MenuBuilder;

class AdminMenuBuilder extends MenuBuilder
{
    public function createAdminMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
        
        $menu->addChild(
            'home',
            array('route' =>  'homepage')
        );
        
        $menu->addChild($this->activeEnrollmentMenu($request));
        
        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            // site admin
            $menu->addChild($this->siteManagementMenu($request));
        } elseif ($this->securityContext->isGranted('ROLE_ORG_USER')) {
            // organization
            $menu->addChild($this->organizationManagementMenu($request));
        } elseif ($this->securityContext->isGranted('ROLE_COUNCIL_USER')) {
            // council
            $menu->addChild($this->councilManagementMenu($request));
        } else {
            // region
            $menu->addChild($this->regionManagementMenu($request));
        }
        
        $this->addChild($this->reportMenu($request));
        
        $this->addChild($this->profileMenu($request));
        
        return $menu;
    }
    
    public function siteManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('site management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        $menu->addChild($this->organizationManagementMenu($request));
        
        $menu->addChild($this->councilManagementMenu($request, false));
        
        $menu->addChild($this->regionManagementMenu($request, false));
       
        return $menu;
    }
    
    public function organizationManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('organization management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        $menu->addChild(
            'organization settings',
            array(
                'route' => 'volleyball_organization_edit',
                'routeParameters' => array(
                    'slug' => $this->securityContext->getUser()->ActiveEnrollment()->getOrganization()->getSlug()
                )
            )
        );
        
        return $menu;
    }
    
    public function councilManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('council management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        $menu->addChild(
            'council settings',
            array(
                'route' => 'volleyball_council_edit',
                'routeParameters' => array(
                    'slug' => $this->securityContext->getUser()->ActiveEnrollment()->getCouncil()->getSlug()
                )
            )
        );
        
        return $menu;
    }
    
    public function regionManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('region management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        $menu->addChild(
            'region settings',
            array(
                'route' => 'volleyball_region_edit',
                'routeParameters' => array(
                    'slug' => $this->securityContext->getUser()->ActiveEnrollment()->getRegion()->getSlug()
                )
            )
        );
        
        return $menu;
    }
}
