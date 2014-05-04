<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

class LevelType extends SearchType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('name');
        $builder->add('special');
    }

    public function getName() {
        return 'level_search';
    }
}
