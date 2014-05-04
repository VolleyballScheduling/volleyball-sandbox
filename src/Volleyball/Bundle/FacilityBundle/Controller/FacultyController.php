<?php
namespace Volleyball\Bundle\FacilityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\FacilityBundle\Entity\Faculty;
use Volleyball\Bundle\FacilityBundle\Form\Type\FacultyType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class FacultyController extends Controller
{
    /**
     * @Route("/", name="volleyball_faculty_index")
     * @Template("VolleyballFacilityBundle:Faculty:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballFacilityBundle:Faculty')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'facultys' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_faculty_show")
     * @Template("VolleyballFacilityBundle:Faculty:show.html.twig")
     */
    public function showAction($slug)
    {
        $faculty = $this->getDoctrine()
            ->getRepository('VolleyballFacilityBundle:Faculty')
            ->findOneBySlug($slug);

        if (!$faculty) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching faculty found.'
                );
            $this->redirect($this->generateUrl('volleyball_faculty_index'));
        }

        return array('faculty' => $faculty);
    }

    /**
     * @Route("/new", name="volleyball_faculty_new")
     * @Template("VolleyballFacilityBundle:Faculty:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $faculty = new Faculty();
        $form = $this->createForm(new FacultyType(), $faculty);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($faculty);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'faculty created.'
                );

                return $this->render(
                    'VolleyballFacilityBundle:Faculty:show.html.twig',
                    array(
                        'faculty' => $faculty
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
