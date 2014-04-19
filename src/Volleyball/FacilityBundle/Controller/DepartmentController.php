<?php
namespace Volleyball\FacilityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\FacilityBundle\Entity\Department;
use Volleyball\FacilityBundle\Form\Type\DepartmentType;
use Volleyball\UtilityBundle\Controller\UtilityController as Controller;

class DepartmentController extends Controller
{
    /**
     * @Route("/", name="volleyball_department_index")
     * @Template("VolleyballFacilityBundle:Department:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballFacilityBundle:Department')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'departments' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_department_show")
     * @Template("VolleyballFacilityBundle:Department:show.html.twig")
     */
    public function showAction($slug)
    {
        $department = $this->getDoctrine()
            ->getRepository('VolleyballFacilityBundle:Department')
            ->findOneBySlug($slug);

        if (!$department) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching department found.'
                );
            $this->redirect($this->generateUrl('volleyball_department_index'));
        }

        return array('department' => $department);
    }

    /**
     * @Route("/new", name="volleyball_department_new")
     * @Template("VolleyballFacilityBundle:Department:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $department = new Department();
        $form = $this->createForm(new DepartmentType(), $department);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($department);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'department created.'
                );

                return $this->render(
                    'VolleyballFacilityBundle:Department:show.html.twig',
                    array(
                        'department' => $department
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
