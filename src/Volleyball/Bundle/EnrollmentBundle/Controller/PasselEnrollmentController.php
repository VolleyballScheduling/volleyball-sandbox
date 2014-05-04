<?php
namespace Volleyball\Bundle\EnrollmentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\Bundle\EnrollmentBundle\Entity\PasselEnrollment;
use Volleyball\Bundle\EnrollmentBundle\Form\Type\PasselEnrollmentType;
use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class PasselEnrollmentController extends Controller
{
    /**
     * @Route("/", name="volleyball_passel_enrollment_index")
     * @Template("VolleyballEnrollmentBundle:PasselEnrollment:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballEnrollmentBundle:PasselEnrollment')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'passel_enrollments' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_passel_enrollment_show")
     * @Template("VolleyballEnrollmentBundle:PasselEnrollment:show.html.twig")
     */
    public function showAction($slug)
    {
        $passel_enrollment = $this->getDoctrine()
            ->getRepository('VolleyballEnrollmentBundle:PasselEnrollment')
            ->findOneBySlug($slug);

        if (!$passel_enrollment) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching passel_enrollment found.'
                );
            $this->redirect($this->generateUrl('volleyball_passel_enrollment_index'));
        }

        return array('passel_enrollment' => $passel_enrollment);
    }

    /**
     * @Route("/new", name="volleyball_passel_enrollment_new")
     * @Template("VolleyballEnrollmentBundle:PasselEnrollment:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $passel_enrollment = new PasselEnrollment();
        $form = $this->createForm(new PasselEnrollmentType(), $passel_enrollment);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($passel_enrollment);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'passel_enrollment created.'
                );

                return $this->render(
                    'VolleyballEnrollmentBundle:PasselEnrollment:show.html.twig',
                    array(
                        'passel_enrollment' => $passel_enrollment
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
