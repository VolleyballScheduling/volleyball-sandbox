<?php

namespace Volleyball\PasselBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface,
    FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationPasselLeaderFormType extends BaseType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        parent::buildForm( $builder, $options );

        // add your custom field
        $builder->add('passel',
                      'entity',
                      array(
                        'property'  =>  'name',
                        'class'     => 'Volleyball\PasselBundle\Entity\Passel'
        ) );
    }

    public function getName()
    {
        return 'volleyball_passel_leader_registration';
    }
}
