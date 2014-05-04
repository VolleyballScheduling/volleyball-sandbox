<?php
namespace Volleyball\Bundle\EnrollmentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment;
use Volleyball\Bundle\EnrollmentBundle\Form\Type\ActiveEnrollmentType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class ActiveEnrollmentController extends Controller
{
    /**
     * @Route("/", name="volleyball_active_enrollment_index")
     * @Template("VolleyballEnrollmentBundle:ActiveEnrollment:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballEnrollmentBundle:ActiveEnrollment')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'active_enrollments' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_active_enrollment_show")
     * @Template("VolleyballEnrollmentBundle:ActiveEnrollment:show.html.twig")
     */
    public function showAction($slug)
    {
        $active_enrollment = $this->getDoctrine()
            ->getRepository('VolleyballEnrollmentBundle:ActiveEnrollment')
            ->findOneBySlug($slug);

        if (!$active_enrollment) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching active_enrollment found.'
                );
            $this->redirect($this->generateUrl('volleyball_active_enrollment_index'));
        }

        return array('active_enrollment' => $active_enrollment);
    }

    /**
     * @Route("/new", name="volleyball_active_enrollment_new")
     * @Template("VolleyballEnrollmentBundle:ActiveEnrollment:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $active_enrollment = new ActiveEnrollment();
        $form = $this->createForm(new ActiveEnrollmentType(), $active_enrollment);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($active_enrollment);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'active_enrollment created.'
                );

                return $this->render(
                    'VolleyballEnrollmentBundle:ActiveEnrollment:show.html.twig',
                    array(
                        'active_enrollment' => $active_enrollment
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    public function organizationAction(Request $request)
    {
        $organization = new Organization();
        $form = $this->createForm(new ActiveEnrollmentOrganizationType(), $organization);

        if ("POST" == $request->getMethod()) {
         
        }

        return array('form' => $form->createView());
    }

    public function councilAction(Request $request)
    {
        $council = new Council();
        $form = $this->createForm(new ActiveEnrollmentCouncilType(), $council);

        if ("POST" == $request->getMethod()) {
         
        }

        return array('form' => $form->createView());
    }

    public function regionAction(Request $request)
    {
        $region = new Region();
        $form = $this->createForm(new ActiveEnrollmentRegionType(), $region);

        if ("POST" == $request->getMethod()) {
         
        }

        return array('form' => $form->createView());
    }

    public function passelAction(Request $request)
    {
        $passel = new Passel();
        $form = $this->createForm(new ActiveEnrollmentPasselType(), $passel);

        if ("POST" == $request->getMethod()) {
         
        }

        return array('form' => $form->createView());
    }

    public function attendeeAction(Request $request)
    {
        $attendee = new Attendee();
        $form = $this->createForm(new ActiveEnrollmentAttendeeType(), $attendee);

        if ("POST" == $request->getMethod()) {
         
        }

        return array('form' => $form->createView());
    }

    public function facilityAction(Request $request)
    {
        $facility = new Facility();
        $form = $this->createForm(new ActiveEnrollmentFacilityType(), $facility);

        if ("POST" == $request->getMethod()) {
         
        }

        return array('form' => $form->createView());
    }

    public function weekAction(Request $request)
    {
        $week = new Week();
        $form = $this->createForm(new ActiveEnrollmentWeekType(), $week);

        if ("POST" == $request->getMethod()) {
         
        }

        return array('form' => $form->createView());
    }
}
