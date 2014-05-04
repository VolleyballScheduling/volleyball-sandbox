<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Volleyball\Bundle\PasselBundle\Entity\Passel;

class PasselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('type');
        $builder->add('region');
        $builder->add('leader');
    }

    public function getName() {
        return 'passel';
    }
}
