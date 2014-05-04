<?php
namespace Volleyball\Bundle\EnrollmentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Volleyball\Bundle\EnrollmentBundle\Entity\AttendeeEnrollment;
use Volleyball\Bundle\EnrollmentBundle\Form\Type\AttendeeEnrollmentType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class AttendeeEnrollmentController extends Controller
{
    /**
     * @Route("/", name="volleyball_attendee_enrollment_index")
     * @Template("VolleyballEnrollmentBundle:AttendeeEnrollment:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballEnrollmentBundle:AttendeeEnrollment')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'attendee_enrollments' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_attendee_enrollment_show")
     * @Template("VolleyballEnrollmentBundle:AttendeeEnrollment:show.html.twig")
     */
    public function showAction($slug)
    {
        $attendee_enrollment = $this->getDoctrine()
            ->getRepository('VolleyballEnrollmentBundle:AttendeeEnrollment')
            ->findOneBySlug($slug);

        if (!$attendee_enrollment) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching attendee_enrollment found.'
                );
            $this->redirect($this->generateUrl('volleyball_attendee_enrollment_index'));
        }

        return array('attendee_enrollment' => $attendee_enrollment);
    }

    /**
     * @Route("/new", name="volleyball_attendee_enrollment_new")
     * @Template("VolleyballEnrollmentBundle:AttendeeEnrollment:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $attendee_enrollment = new AttendeeEnrollment();
        $form = $this->createForm(new AttendeeEnrollmentType(), $attendee_enrollment);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($attendee_enrollment);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'attendee_enrollment created.'
                );

                return $this->render(
                    'VolleyballEnrollmentBundle:AttendeeEnrollment:show.html.twig',
                    array(
                        'attendee_enrollment' => $attendee_enrollment
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
