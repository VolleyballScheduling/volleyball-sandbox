<?php
namespace Volleyball\Bundle\CourseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\CourseBundle\Entity\Course;
use Volleyball\Bundle\CourseBundle\Form\Type\CourseType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class CourseController extends Controller
{
    /**
     * @Route("/", name="volleyball_course_index")
     * @Template("VolleyballCourseBundle:Course:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballCourseBundle:Course')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'courses' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_course_show")
     * @Template("VolleyballCourseBundle:Course:show.html.twig")
     */
    public function showAction($slug)
    {
        $course = $this->getDoctrine()
            ->getRepository('VolleyballCourseBundle:Course')
            ->findOneBySlug($slug);

        if (!$course) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching course found.'
                );
            $this->redirect($this->generateUrl('volleyball_course_index'));
        }

        return array('course' => $course);
    }

    /**
     * @Route("/new", name="volleyball_course_new")
     * @Template("VolleyballCourseBundle:Course:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(new CourseType(), $course);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($course);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'course created.'
                );

                return $this->render(
                    'VolleyballCourseBundle:Course:show.html.twig',
                    array(
                        'course' => $course
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
