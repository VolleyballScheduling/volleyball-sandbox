<?php
namespace Volleyball\Bundle\UtilityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Volleyball\Bundle\UtilityBundle\Controller\UtilityController as Controller;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage)
     * @Template("VolleyballUtilityBundle:Homepage:index.html.twig")
     */
    public function indexAction(
        $dashboard = true
    ) {
        /**
         * If user is authorized AND user isn't implicitly requesting the welcome pages
         */
        if ($dashboard && $this->get('security.context')->isGranted('ROLE_USER')) {
            $session = $this->get('security.context');
            
            if ($session->isGranted('ROLE_ADMIN')) {
                /**
                 * Admin user
                 */
                $this->forwardToDashboard(
                    ($session->isGranted(' ROLE_SUPER_ADMIN') ? 'ROLE_SUPER_ADMIN' : 'ROLE_ADMIN')
                );
            } elseif ($session->isGranted('ROLE_REGION_USER')) {
                /**
                 * Region user
                 */
                $this->forwardToDashboard(
                    ($session->isGranted(' ROLE_REGION_ADMIN') ? 'ROLE_REGION_ADMIN' : 'ROLE_REGION_USER')
                );
            } elseif ($session->isGranted('ROLE_ORG_USER')) {
                /**
                 * Organization user
                 */
                $this->forwardToDashboard(
                    ($session->isGranted(' ROLE_ORG_ADMIN') ? 'ROLE_ORG_ADMIN' : 'ROLE_ORG_USER')
                );
            } elseif ($session->isGranted('ROLE_FACILITY_ADMIN ')) {
                /**
                 * Faculty
                 */
                $this->forwardToDashboard(
                    (
                        $session->isGranted(' ROLE_FACILITY_ADMIN') ?
                            'ROLE_FACILITY_ADMIN' :
                            ($session->isGranted('ROLE_FACILITY_FACULTY') ?
                                'ROLE_FACILITY_FACULTY' :
                                'ROLE_FACILITY_USER'
                            )
                    )
                );
            } elseif ($session->isGranted('ROLE_PASSEL_USER')) {
                /**
                 * Leader or Attendee user
                 */
                $this->forwardToDashboard(
                    ($session->isGranted(' ROLE_PASSEL_ADMIN') ?
                        'ROLE_PASSEL_ADMIN' :
                        ($session->isGranted('ROLE_PASSEL_LEADER') ?
                            'ROLE_PASSEL_LEADER' :
                            'ROLE_PASSEL_USER'
                        )
                    )
                );
            }
        }
        
        // Welcome page
        // Carousel
        $carousel = $this->get('volleyball.repository.carousel')
            ->findOneBySlug('splash');
    
        if (!$carousel) {
            $carousel = array('items' => array());
        }

        // last username entered by the user
        $lastUsername = (!$this->securityContext->isGranted('ROLE_USER')) ?
                '' :
                $this->securityContext->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return array(
            'carousel' => $carousel,
            'csrf_token' => $csrfToken,
            'last_username' => $lastUsername
        );
    }

    /**
     * @Route("/about", name="volleyball_about")
     * @return type
     */
    public function aboutAction()
    {
        return $this->render('VolleyballUtilityBundle:Homepage:about.html.twig');
    }

    /**
     * @Route("/help", name="volleyball_help")
     * @return type
     */
    public function helpAction()
    {
        return $this->render('VolleyballUtilityBundle:Homepage:help.html.twig');
    }

    /**
     * @Route("/contact", name="volleyball_contact")
     * @return type
     */
    public function contactAction()
    {
        return $this->render('VolleyballUtilityBundle:Homepage:contact.html.twig');
    }
    
    /**
     * Forward to dashboard
     * 
     * @param string $role role
     */
    private function forwardToDashboard($role)
    {
        /**
         * @todo find a cleaner way to match the role to the controller
         *
         * $roles = Yaml::parse($this->locator->locate('security.yml', null, null));
         * $roles = new ArrayCollection($roles['security']['role_hierarchy']);
         */
        $roleEntities = array(
            'ROLE_PASSEL_USER'          =>  'VolleyballPasselBundle:Attendee:dashboard',
            'ROLE_PASSEL_LEADER'        =>  'VolleyballPasselBundle:Leader:dasboard',
            'ROLE_PASSEL_ADMIN'         =>  'VolleyballPasselBundle:Leader:dasboard',
            'ROLE_FACILITY_USER'        =>  'VolleyballFacilityBundle:Faculty:dashboard',
            'ROLE_FACILITY_FACULTY'     =>  'VolleyballFacilityBundle:Faculty:dashboard',
            'ROLE_FACILITY_ADMIN'       =>  'VolleyballFacilityBundle:Faculty:dashboard',
            'ROLE_ORG_USER'             =>  'VolleyballOrganizationBundle:Organization:dashboard',
            'ROLE_ORG_ADMIN'            =>  'VolleyballOrganizationBundle:Organization:dashboard',
            'ROLE_REGION_USER'          =>  'VolleyballOrganizationBundle:Region:dashboard',
            'ROLE_REGION_ADMIN'         =>  'VolleyballOrganizationBundle:Region:dashboard',
            'ROLE_ADMIN'                =>  'VolleyballUserBundle:Admin:dashboard',
            'ROLE_SUPER_ADMIN'          =>  'VolleyballUserBundle:Admin:dashboard'
        );
        $this->forward($roleEntities[$role]);
    }
}
