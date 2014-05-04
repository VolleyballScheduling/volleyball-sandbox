<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

class PasselType extends SearchType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('type');
    }

    public function getName() {
        return 'passel_search';
    }
}
