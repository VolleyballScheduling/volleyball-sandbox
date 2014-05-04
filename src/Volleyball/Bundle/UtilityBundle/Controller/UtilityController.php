<?php
namespace Volleyball\Bundle\UtilityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Common\Collections\ArrayCollection;

class UtilityController extends Controller implements ContainerAwareInterface
{
    /**
     * configuration settings
     * @var ArrayCollection
     */
    private $configs;

    /**
     * config file locator
     * @var FileLocater
     */
    private $locator;

    /**
     * container
     * @var type
     */
    protected $container;

    /**
     * security context
     * @var SecurityContext
     */
    protected $securityContext;
    
    /**
     * breadcrumb array
     * @var array 
     */
    protected $breadcrumbs = array();

    /**
     * set container
     * @param type $container container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        $this->securityContext = $this->container->get('security.context');
        
        $this->generateBreadcrumbs();
    }

    /**
     * __construct
     */
    public function __construct()
    {
        $path = __DIR__ .DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' .
                DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
                'app' . DIRECTORY_SEPARATOR;
        $configDirectories = array(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'config',
            $path . 'config'
        );
        $this->locator = new FileLocator($configDirectories);

    }

    /**
     * Get configuration file parameter
     * @param string $parameter
     * @return type
     */
    public function getParameter($parameter)
    {
        if (!$this->configs instanceof ArrayCollection) {
            $this->generateConfigs($file = 'parameters.yml', null, false);
        }

        return $this->configs->get($parameter);
    }

    /**
     * Generate configuration array
     * @param string $file
     * @param string $path
     * @param bool $retFile
     */
    private function generateConfigs($file, $path = null, $retFile = false)
    {
        $configs = Yaml::parse($this->locator->locate($file, $path, $retFile)[0]);

        $this->configs = new ArrayCollection($configs['parameters']);
    }
    
    /**
     * Generate breadcrumbs
     */
    public function generateBreadcrumbs()
    {
        $this->breadcrumbs = $this->get('white_october_breadcrumbs');
        
        $this->breadcrumbs->addItem(
            'dashboard',
            $this->get('router')->generate('homepage')
        );
    }
}
