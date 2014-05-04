<?php
namespace Volleyball\Bundle\FacilityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\FacilityBundle\Entity\Quarters;
use Volleyball\Bundle\FacilityBundle\Form\Type\QuartersType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class QuartersController extends Controller
{
    /**
     * @Route("/", name="volleyball_quarters_index")
     * @Template("VolleyballFacilityBundle:Quarters:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballFacilityBundle:Quarters')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'quarterss' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_quarters_show")
     * @Template("VolleyballFacilityBundle:Quarters:show.html.twig")
     */
    public function showAction($slug)
    {
        $quarters = $this->getDoctrine()
            ->getRepository('VolleyballFacilityBundle:Quarters')
            ->findOneBySlug($slug);

        if (!$quarters) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching quarters found.'
                );
            $this->redirect($this->generateUrl('volleyball_quarters_index'));
        }

        return array('quarters' => $quarters);
    }

    /**
     * @Route("/new", name="volleyball_quarters_new")
     * @Template("VolleyballFacilityBundle:Quarters:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $quarters = new Quarters();
        $form = $this->createForm(new QuartersType(), $quarters);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($quarters);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'quarters created.'
                );

                return $this->render(
                    'VolleyballFacilityBundle:Quarters:show.html.twig',
                    array(
                        'quarters' => $quarters
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
