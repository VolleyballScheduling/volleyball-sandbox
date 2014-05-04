<?php
namespace Volleyball\Bundle\CourseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Volleyball\Bundle\CourseBundle\Entity\VbClass;

class VbClassType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('name');
    $builder->add('course');
    $builder->add('faculty');
    $builder->add('department');
    $builder->add('period');
  }

  public function getName() {
    return 'volleyball_class';
  }
}
