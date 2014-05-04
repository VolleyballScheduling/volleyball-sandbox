<?php
namespace Volleyball\Bundle\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;

use Volleyball\Bundle\UtilityBundle\Entity\Carousel;
use Volleyball\Bundle\UtilityBundle\Entity\CarouselItem;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class UserController extends Controller
{
    protected $available_roles = array();

    /**
     * Index
     * 
     * @Route("/users", name="volleyball_user_index")
     * @return  array 
     */
    public function indexAction()
    {
        return $this->forward('VolleyballUtilityBundle:Homepage:index');
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
}
