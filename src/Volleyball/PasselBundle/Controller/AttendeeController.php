<?php
namespace Volleyball\PasselBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\View\TwitterBootstrapView;

use Volleyball\UtilityBundle\Controller\UtilityController as Controller;
use Volleyball\PasselBundle\Entity\Attendee;
use Volleyball\PasselBundle\Form\Type\AttendeeType;
use Volleyball\PasselBundle\Form\Type\Search\AttendeeType as AttendeeSearchType;

class AttendeeController extends Controller
{
    /**
     * @Route("/", name="volleyball_attendee_index")
     * @Template("VolleyballPasselBundle:Attendee:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballPasselBundle:Attendee')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'attendees' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="volleyball_attendee_new")
     * @Template("VolleyballPasselbundle:Attendee:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $attendee = new Attendee();
        $form = $this->createForm(new AttendeeType(), $attendee);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($attendee);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'attendee created.'
                );

                return $this->render(
                    'VolleyballPasselbundle:Attendee:show.html.twig',
                    array('attendee' => $attendee )
                );
            }
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/search", name="volleyball_attendee_search")
     * @Template("VolleyballPasselBundle:Attendee:search.html.twig")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new AttendeeSearchType());
        
        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                /** @TODO finish attendee search, also restrict access */
                $attendees = array();

                return $this->render(
                    'VolleyballPasselbundle:Attendee:index.html.twig',
                    array('attendees' => $attendees )
                );
            }
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/{slug}", name="volleyball_attendee_show")
     * @Template("VolleyballPasselBundle:Attendee:show.html.twig")
     */
    public function showAction($slug)
    {
        $attendee = $this->getDoctrine()
            ->getRepository('VolleyballPasselbundle:Attendee')
            ->findOneBySlug($slug);

        if (!$attendee) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching attendee found.'
            );
            $this->redirect($this->generateUrl('volleyball_attendee_index'));
        }

        return array('attendee' => $attendee);
    }
}
