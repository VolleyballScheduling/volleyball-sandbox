<?php
namespace Volleyball\Bundle\FacilityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Volleyball\Bundle\FacilityBundle\Entity\Facility;
use Volleyball\Bundle\FacilityBundle\Form\Type\FacilityType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class FacilityController extends Controller
{
    /**
     * @Route("/", name="volleyball_facility_index")
     * @Template("VolleyballFacilityBundle:Facility:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballFacilityBundle:Facility')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'facilitys' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_facility_show")
     * @Template("VolleyballFacilityBundle:Facility:show.html.twig")
     */
    public function showAction($slug)
    {
        $facility = $this->getDoctrine()
            ->getRepository('VolleyballFacilityBundle:Facility')
            ->findOneBySlug($slug);

        if (!$facility) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching facility found.'
                );
            $this->redirect($this->generateUrl('volleyball_facility_index'));
        }

        return array('facility' => $facility);
    }

    /**
     * @Route("/new", name="volleyball_facility_new")
     * @Template("VolleyballFacilityBundle:Facility:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $facility = new Facility();
        $form = $this->createForm(new FacilityType(), $facility);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($facility);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'facility created.'
                );

                return $this->render(
                    'VolleyballFacilityBundle:Facility:show.html.twig',
                    array(
                        'facility' => $facility
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
