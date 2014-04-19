<?php
namespace Volleyball\UtilityBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Security\Core\SecurityContextInterface;
use JMS\TranslationBundle\Annotation\Ignore;

abstract class BaseBuilder
{
    protected $factory;

    protected $securityContext;

    protected $translator;

    protected $request;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->securityContext = $securityContext;
        $this->translator = $translator;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    protected function translate($label, $parameters = array())
    {
        return $this->translator->trans(/** @Ignore */ $label, $parameters, 'menu');
    }
}
