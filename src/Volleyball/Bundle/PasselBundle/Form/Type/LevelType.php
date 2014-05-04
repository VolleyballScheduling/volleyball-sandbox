<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Volleyball\Bundle\PasselBundle\Entity\Level;

class LevelType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('name');
    $builder->add('special');
    $builder->add('organization');
  }

  public function getName() {
    return 'level';
  }
}
