<?php
namespace Volleyball\Bundle\CourseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\CourseBundle\Entity\Period;
use Volleyball\Bundle\CourseBundle\Form\Type\PeriodType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class PeriodController extends Controller
{
    /**
     * @Route("/", name="volleyball_period_index")
     * @Template("VolleyballCourseBundle:Period:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballCourseBundle:Period')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'periods' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_period_show")
     * @Template("VolleyballCourseBundle:Period:show.html.twig")
     */
    public function showAction($slug)
    {
        $period = $this->getDoctrine()
            ->getRepository('VolleyballCourseBundle:Period')
            ->findOneBySlug($slug);

        if (!$period) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching period found.'
                );
            $this->redirect($this->generateUrl('volleyball_period_index'));
        }

        return array('period' => $period);
    }

    /**
     * @Route("/new", name="volleyball_period_new")
     * @Template("VolleyballCourseBundle:Period:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $period = new Period();
        $form = $this->createForm(new PeriodType(), $period);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($period);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'period created.'
                );

                return $this->render(
                    'VolleyballCourseBundle:Period:show.html.twig',
                    array(
                        'period' => $period
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
