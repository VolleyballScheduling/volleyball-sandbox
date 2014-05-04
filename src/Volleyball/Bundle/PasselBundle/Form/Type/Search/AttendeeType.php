<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

class AttendeeType extends SearchType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name');
        $builder->add('last_name');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Volleyball\Bundle\PasselBundle\Entity\Attendee'
       ));
    }

    public function getName()
    {
        return 'attendee_search';
    }
}
