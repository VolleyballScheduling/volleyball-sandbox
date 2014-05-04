<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

class LeaderType extends SearchType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name');
        $builder->add('last_name');
    }

    public function getName()
    {
        return 'leader_search';
    }
}
