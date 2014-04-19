<?php
namespace Volleyball\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;

use Volleyball\UtilityBundle\Entity\Carousel;
use Volleyball\UtilityBundle\Entity\CarouselItem;
use Volleyball\UtilityBundle\Controller\UtilityController as Controller;

class UserController extends Controller
{
    protected $available_roles = array();

    /**
     * Index
     * 
     * @param integer $pager1 pager1 page
     * @param integer $pager2 pager2 page
     * 
     * @Route("/", name="homepage")
     * @return  array 
     */
    public function indexAction($pager1 = 1, $pager2 = 1)
    {
        
        /**
         * If the user is atleast authenticated
         * with the system then we can continue.
         */
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $session = $this->get('security.context');
            if ($session->isGranted('ROLE_ADMIN')) {
                $this->forwardToDashboard(($session->isGranted(' ROLE_SUPER_ADMIN') ? 'ROLE_SUPER_ADMIN' : 'ROLE_ADMIN'));
            } elseif ($session->isGranted('ROLE_REGION_USER')) {
                $this->forwardToDashboard(($session->isGranted(' ROLE_REGION_ADMIN') ? 'ROLE_REGION_ADMIN' : 'ROLE_REGION_USER'));
            } elseif ($session->isGranted('ROLE_ORG_USER')) {
                $this->forwardToDashboard(($session->isGranted(' ROLE_ORG_ADMIN') ? 'ROLE_ORG_ADMIN' : 'ROLE_ORG_USER'));
            } elseif ($session->isGranted('ROLE_FACILITY_ADMIN ')) {
                $this->forwardToDashboard(($session->isGranted(' ROLE_FACILITY_ADMIN') ? 'ROLE_FACILITY_ADMIN' : ($session->isGranted('ROLE_FACILITY_FACULTY') ? 'ROLE_FACILITY_FACULTY' : 'ROLE_FACILITY_USER')));
            } elseif ($session->isGranted('ROLE_PASSEL_USER')) {
                $this->forwardToDashboard(($session->isGranted(' ROLE_PASSEL_ADMIN') ? 'ROLE_PASSEL_ADMIN' : ($session->isGranted('ROLE_PASSEL_LEADER') ? 'ROLE_PASSEL_LEADER' : 'ROLE_PASSEL_USER')));
            }
        }

        return $this->forward('VolleyballUtilityBundle:Homepage:index');
    }

    /**
     * Forward to dashboard
     * 
     * @param string $role role
     */
    private function forwardToDashboard($role)
    {
        /**
         * @todo find a cleaner way to match the role to the controller
         */
        $roleEntities = array(
            'ROLE_PASSEL_USER'          =>  'VolleyballPasselBundle:Attendee:dashboard',
            'ROLE_PASSEL_LEADER'        =>  'VolleyballPasselBundle:Leader:dasboard',
            'ROLE_PASSEL_ADMIN'         =>  'VolleyballPasselBundle:Leader:dasboard',
            'ROLE_FACILITY_USER'        =>  'VolleyballFacilityBundle:Faculty:dashboard',
            'ROLE_FACILITY_FACULTY'     =>  'VolleyballFacilityBundle:Faculty:dashboard',
            'ROLE_FACILITY_ADMIN'       =>  'VolleyballFacilityBundle:Faculty:dashboard',
            'ROLE_ORG_USER'             =>  'VolleyballOrganizationBundle:Organization:dashboard',
            'ROLE_ORG_ADMIN'            =>  'VolleyballOrganizationBundle:Organization:dashboard',
            'ROLE_REGION_USER'          =>  'VolleyballOrganizationBundle:Region:dashboard',
            'ROLE_REGION_ADMIN'         =>  'VolleyballOrganizationBundle:Region:dashboard',
            'ROLE_ADMIN'                =>  'VolleyballUserBundle:Admin:dashboard',
            'ROLE_SUPER_ADMIN'          =>  'VolleyballUserBundle:Admin:dashboard'
        );
        $this->forward($roleEntities[ $role ]);
    }

    public function registerAction()
    {
        $form = $this->createForm(
            new RegistrationType(),
            new Registration()
        );

        return $this->render(
            'VolleyballUserBundle:User:register.html.twig',
            array('form'  =>  $form->createView())
        );
    }

    public function createAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->bind($this->getRequest());

        if ($form->isValid()) {
            $registration = $form->getData();

            $em->persist($registration->getUser());
            $em->flush();

            return $this->redirect('VolleyballUserBundle:User:dashboard');
        }

        return $this->render(
            'VolleyballUserBundle:User:register.html.twig',
            array('form'  =>  $form->createView())
        );
    }

    public function aboutAction()
    {
        return $this->render('VolleyballUserBundle:Base:about.html.twig');
    }

    public function helpAction()
    {
        return $this->render('VolleyballUserBundle:Base:help.html.twig');
    }

    public function contactAction()
    {
        return $this->render('VolleyballUserBundle:Base:contact.html.twig');
    }
}
