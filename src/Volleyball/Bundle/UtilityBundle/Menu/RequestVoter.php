<?php
namespace Volleyball\Bundle\UtilityBundle\Menu;
 
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
 
class RequestVoter implements VoterInterface
{
 
    private $container;
 
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
 
    public function matchItem(ItemInterface $item)
    {
    	if ($item->getUri() === $this->container->get('request')->getRequestUri()) {
    		
            return true;
        } else if($item->getUri() !== '/' && (substr($this->container->get('request')->getRequestUri(), 0, strlen($item->getUri())) === $item->getUri())) {
        	
            return true;
    	}
        
        return null;
    }
    
}