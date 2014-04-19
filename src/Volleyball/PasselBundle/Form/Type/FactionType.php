<?php
namespace Volleyball\PasselBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Volleyball\PasselBundle\Entity\Faction;

class FactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('avatar', 'file');
        $builder->add('passel');
    }

    public function getName() {
        return 'faction';
    }
}
