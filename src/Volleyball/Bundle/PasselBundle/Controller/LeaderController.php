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
use Volleyball\Bundle\PasselBundle\Entity\Leader;
use Volleyball\Bundle\PasselBundle\Form\Type\LeaderType;
use Volleyball\Bundle\PasselBundle\Form\Type\Search\LeaderType as LeaderSearchType;

class LeaderController extends Controller
{
    /**
     * @Route("/", name="volleyball_leader_index")
     * @Template("VolleyballPasselBundle:Leader:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballPasselBundle:Leader')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'leaders' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="volleyball_leader_new")
     * @Template("VolleyballPasselbundle:Leader:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $leader = new Leader();
        $form = $this->createForm(new LeaderType(), $leader);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($leader);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'leader created.'
                );

                return $this->render(
                    'VolleyballPasselbundle:Leader:show.html.twig',
                    array('leader' => $leader)
                );
            }
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/search", name="volleyball_leader_search")
     * @Template("VolleyballPasselBundle:Leader:search.html.twig")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new LeaderSearchType());
        
        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                /** @TODO finish leader search, also restrict access */
                $leaders = array();

                return $this->render(
                    'VolleyballPasselbundle:Leader:index.html.twig',
                    array('leaders' => $leaders )
                );
            }
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/{slug}", name="volleyball_leader_show")
     * @Template("VolleyballPasselBundle:Leader:show.html.twig")
     */
    public function showAction($slug)
    {
        $leader = $this->getDoctrine()
            ->getRepository('VolleyballPasselbundle:Leader')
            ->findOneBySlug($slug);

        if (!$leader) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching leader found.'
            );
            $this->redirect($this->generateUrl('volleyball_leader_index'));
        }

        return array('leader' => $leader);
    }
}
