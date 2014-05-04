<?php
namespace Volleyball\Bundle\CourseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\CourseBundle\Entity\VbClass;
use Volleyball\Bundle\CourseBundle\Form\Type\VbClassType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class VbClassController extends Controller
{
    /**
     * @Route("/", name="volleyball_class_index")
     * @Template("VolleyballCourseBundle:VbClass:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballCourseBundle:VbClass')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'classs' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_class_show")
     * @Template("VolleyballCourseBundle:VbClass:show.html.twig")
     */
    public function showAction($slug)
    {
        $class = $this->getDoctrine()
            ->getRepository('VolleyballCourseBundle:VbClass')
            ->findOneBySlug($slug);

        if (!$class) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching class found.'
                );
            $this->redirect($this->generateUrl('volleyball_class_index'));
        }

        return array('class' => $class);
    }

    /**
     * @Route("/new", name="volleyball_class_new")
     * @Template("VolleyballCourseBundle:VbClass:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $class = new VbClass();
        $form = $this->createForm(new VbClassType(), $class);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($class);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'class created.'
                );

                return $this->render(
                    'VolleyballCourseBundle:VbClass:show.html.twig',
                    array(
                        'class' => $class
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
