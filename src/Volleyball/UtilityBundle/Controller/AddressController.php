<?php
namespace Volleyball\UtilityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\UtilityBundle\Entity\Address;
use Volleyball\UtilityBundle\Form\Type\AddressType;
use Volleyball\UtilityBundle\Controller\UtilityController as Controller;

class AddressController extends Controller
{
    /**
     * @Route("/", name="volleyball_address_index")
     * @Template("VolleyballUtilityBundle:Address:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballUtilityBundle:Address')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'addresss' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_address_show")
     * @Template("VolleyballUtilityBundle:Address:show.html.twig")
     */
    public function showAction($slug)
    {
        $address = $this->getDoctrine()
            ->getRepository('VolleyballUtilityBundle:Address')
            ->findOneBySlug($slug);

        if (!$address) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching address found.'
                );
            $this->redirect($this->generateUrl('volleyball_address_index'));
        }

        return array('address' => $address);
    }

    /**
     * @Route("/new", name="volleyball_address_new")
     * @Template("VolleyballUtilityBundle:Address:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $address = new Address();
        $form = $this->createForm(new AddressType(), $address);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($address);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'address created.'
                );

                return $this->render(
                    'VolleyballUtilityBundle:Address:show.html.twig',
                    array(
                        'address' => $address
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
