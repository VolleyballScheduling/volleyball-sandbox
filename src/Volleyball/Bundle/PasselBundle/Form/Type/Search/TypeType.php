<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

class TypeType extends SearchType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
    }

    public function getName()
    {
        return 'type_search';
    }
}
