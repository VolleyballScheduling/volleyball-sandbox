<?php
namespace Volleyball\PasselBundle\Form\Type;

class FactionType extends SearchType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
    }

    public function getName() {
        return 'faction_search';
    }
}
