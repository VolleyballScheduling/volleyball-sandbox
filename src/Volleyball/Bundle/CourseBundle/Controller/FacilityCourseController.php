<?php
namespace Volleyball\Bundle\CourseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\CourseBundle\Entity\FacilityCourse;
use Volleyball\Bundle\CourseBundle\Form\Type\FacilityCourseType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class FacilityCourseController extends Controller
{
    /**
     * @Route("/", name="volleyball_facility_course_index")
     * @Template("VolleyballCourseBundle:FacilityCourse:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballCourseBundle:FacilityCourse')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'facility_courses' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_facility_course_show")
     * @Template("VolleyballCourseBundle:FacilityCourse:show.html.twig")
     */
    public function showAction($slug)
    {
        $facility_course = $this->getDoctrine()
            ->getRepository('VolleyballCoursebundle:FacilityCourse')
            ->findOneBySlug($slug);

        if (!$facility_course) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching facility_course found.'
                );
            $this->redirect($this->generateUrl('volleyball_facility_course_index'));
        }

        return array('facility_course' => $facility_course);
    }

    /**
     * @Route("/new", name="volleyball_facility_course_new")
     * @Template("VolleyballCourseBundle:FacilityCourse:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $facility_course = new FacilityCourse();
        $form = $this->createForm(new FacilityCourseType(), $facility_course);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($facility_course);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'facility course created.'
                );

                return $this->render(
                    'VolleyballCourseBundle:FacilityCourse:show.html.twig',
                    array(
                        'facility_course' => $facility_course
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
