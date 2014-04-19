<?php
namespace Volleyball\ReportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Volleyball\ReportBundle\Entity\Report;
use Volleyball\ReportBundle\Form\Type\ReportType;
use Volleyball\UtilityBundle\Controller\UtilityController as Controller;

class ReportController extends Controller
{
    /**
     * @Route("/", name="volleyball_report_index")
     * @Template("VolleyballReportBundle:Report:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballReportBundle:Report')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'reports' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_report_show")
     * @Template("VolleyballReportBundle:Report:show.html.twig")
     */
    public function showAction($slug)
    {
        $report = $this->getDoctrine()
            ->getRepository('VolleyballReportBundle:Report')
            ->findOneBySlug($slug);

        if (!$report) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching report found.'
                );
            $this->redirect($this->generateUrl('volleyball_report_index'));
        }

        return array('report' => $report);
    }

    /**
     * @Route("/new", name="volleyball_report_new")
     * @Template("VolleyballReportBundle:Report:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $report = new Report();
        $form = $this->createForm(new ReportType(), $report);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($report);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'report created.'
                );

                return $this->render(
                    'VolleyballReportBundle:Report:show.html.twig',
                    array(
                        'report' => $report
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
