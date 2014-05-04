<?php
namespace Volleyball\Bundle\PasselBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\View\TwitterBootstrapView;

use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;
use Volleyball\Bundle\PasselBundle\Entity\Position;
use Volleyball\Bundle\PasselBundle\Form\Type\PositionType;
use Volleyball\Bundle\PasselBundle\Form\Type\Search\PositionType as PositionSearchType;

class PositionController extends Controller
{
    /**
     * @Route("/", name="volleyball_position_index")
     * @Template("VolleyballPasselBundle:Position:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballPasselBundle:Position')
            ->createQueryBuilder('f')
            ->orderBy('f.updated, f.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'positions' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="volleyball_position_new")
     * @Template("VolleyballPasselbundle:Position:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $position = new Position();
        $form = $this->createForm(new PositionType(), $position);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($position);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'position created.'
                );

                return $this->render(
                    'VolleyballPasselbundle:Position:show.html.twig',
                    array('position' => $position)
                );
            }
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/search", name="volleyball_position_search")
     * @Template("VolleyballPasselBundle:Position:search.html.twig")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new PositionSearchType());
        
        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                /** @TODO finish position search, also restrict access */
                $positions = array();

                return $this->render(
                    'VolleyballPasselbundle:Position:index.html.twig',
                    array('positions' => $positions )
                );
            }
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/{slug}", name="volleyball_position_show")
     * @Template("VolleyballPasselBundle:Position:show.html.twig")
     */
    public function showAction($slug)
    {
        $position = $this->getDoctrine()
            ->getRepository('VolleyballPasselbundle:Position')
            ->findOneBySlug($slug);

        if (!$position) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching position found.'
            );
            $this->redirect($this->generateUrl('volleyball_position_index'));
        }

        return array('position' => $position);
    }
}
