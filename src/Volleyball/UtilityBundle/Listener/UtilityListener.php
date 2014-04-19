<?php
namespace Volleyball\UtilityBundle\Listener;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class UtilityListener
{
	/**
	 * container
	 * @var type
	 */
	protected $container;

	/**
	 * __construct
	 * @param Container $container container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * getApiKey
	 * @return String api key
	 */
	public function getApiKey()
	{
		return $this->container->getParameter('api_key');
	}

	/**
	 * getApiSecret
	 * @return String api secret
	 */
	public function getApiSecret()
	{
		return $this->container->getParameter('api_secret');
	}

	public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
    }
}