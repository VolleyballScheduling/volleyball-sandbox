<?php
namespace Volleyball\UtilityBundle\Menu;

use Symfony\Component\HttpFoundation\Request;

use Volleyball\UtilityBundle\Menu\BaseBuilder;

class FacultyMenuBuilder extends BaseBuilder
{
    /**
     * @param Request $request
     * @return menuItem
     */
    public function createFacultyMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $menu->addChild(
            'home',
            array('route' => 'homepage')
        );

        $menu->addChild($this->activeEnrollmentMenu($request));
        
        if ($this->securityContext->isGranted('ROLE_FACULTY_ADMIN')) {
            $menu->addChild($this->facilityManagementMenu($request));
            
            $menu->addChild($this->courseManagementMenu($request));
        } else {
            $menu->addChild($this->classManagementMenu($request));
        }
        
        $this->addChild($this->reportMenu($request));
        
        $this->addChild($this->profileMenu($request));
        
        return $menu;
    }
    
    /**
     * @param Request $request
     * @return menuItem
     */
    public function facilityManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('facility management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        // if admin, show departments menu
        if ($this->securityContext->isGranted('ROLE_FACULTY_ADMIN')) {
            $menu->addChild('departments')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa-list-ul');
            
            $menu['departments']->addChild(
                'list departments',
                array(
                    'route' => 'volleyball_department_index_by_facility',
                    'routeParameter' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getFacility()->getSlug()
                    )
                )
            );
            
            $menu['departments']->addChild(
                'add a department',
                array(
                    'route' => 'volleyball_department_new'
                )
            );
        } else { // else show menu item
            $menu->addChild(
                'departments',
                array(
                    'route' => 'volleyball_department_index_by_facility',
                    'routeParameters' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getFacility()->getSlug()
                    )
                )
            );
        }

        // if admin, show quarters menu
        if ($this->securityContext->isGranted('ROLE_FACULTY_ADMIN')) {
            $menu->addChild('quarters')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa-list-ul');
            
            $menu['quarters']->addChild(
                'list quarters',
                array(
                    'route' => 'volleyball_quarters_index_by_facility',
                    'routeParameter' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getPassel()->getSlug()
                    )
                )
            );
            
            $menu['quarters']->addChild(
                'add a quarters',
                array(
                    'route' => 'volleyball_quarters_new'
                )
            );
        } else { // else show menu item
            $menu->addChild(
                'quarters',
                array(
                    'route' => 'volleyball_quarters_index_by_facility',
                    'routeParameters' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getFacilityl()->getSlug()
                    )
                )
            );
        }
        
        // if admin, show faculty menu
        if ($this->securityContext->isGranted('ROLE_FACULTY_ADMIN')) {
            $menu->addChild('faculty')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa-group');
            
            $menu['faculty']->addChild(
                'list faculty',
                array(
                    'route' => 'volleyball_faculty_index_by_facility',
                    'routeParameter' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getFacility()->getSlug()
                    )
                )
            );
            
            $menu['facultys']->addChild(
                'add faculty',
                array(
                    'route' => 'volleyball_faculty_new'
                )
            );
        } else { // else show menu item
            $menu->addChild(
                'faculty',
                array(
                    'route' => 'volleyball_faculty_index_by_facility',
                    'routeParameters' => array(
                        'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getFacility()->getSlug()
                    )
                )
            );
        }
        
        return $menu;
    }
    
    /**
     * @param Request $request
     * @return menuItem
     */
    public function courseManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('course management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        $menu->addChild(
            'list courses',
            array(
                'route' => 'volleyball_facility_course_index_by_facility',
                'routeParameter' => array(
                    'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getFacility()->getSlug()
                )
            )
        );
        
        $menu->addChild(
            'add a course',
            array(
                'route' => 'volleyball_course_new'
            )
        );
        
        $menu->addChild($this->classManagementMenu($request));
        
        return $menu;
    }
    
    /**
     * @param Request $request
     * @return type
     */
    public function classManagementMenu(Request $request)
    {
        $menu = $this->factory->createItem('class management')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa-cogs');
        
        // attendence
        $menu->addChild(
            'log attendence',
            array(
                'route' => 'volleyball_class_attendence',
                'routeParameters' => array(
                    'slug' => $this->securityContext->getUser()->getActiveEnrollment()->getVbClass()->getSlug()
                )
            )
        );
       
        $menu->addChild(
            'change current period',
            array(
                'route' => 'volleyball_enrollment_active_change_period',
            )
        );
        
        return $menu;
    }
}
