<?php
namespace Volleyball\UtilityBundle\Menu;

use Symfony\Component\HttpFoundation\Request;

use Volleyball\UtilityBundle\Menu\BaseBuilder;

class AttendeeMenuBuilder extends BaseBuilder
{
    public function createAttendeeMenu(Request $request)
    {
        if ($this->securityContext->isGranted('ROLE_AUTHENTICATED_ANONYMOUSLY') ||
            !$this->securityContext->isGranted('ROLE_USER')) {
            return $this->createNonauthMenu($request);
        }

        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $menu->addChild(
            'home',
            array('route' => 'homepage')
        );

        $menu->addChild($this->activeEnrollmentMenu($request));
        
        $menu->addChild($this->courseMenu($request));
        
        $this->addChild($this->reportMenu($request));
        
        $this->addChild($this->profileMenu($request));
        
        return $menu;
    }
}
