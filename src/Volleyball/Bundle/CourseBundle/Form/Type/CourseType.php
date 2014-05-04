<?php
namespace Volleyball\Bundle\CourseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Volleyball\Bundle\CourseBundle\Entity\Course;

class CourseType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('name');
    $builder->add('meritbadge');
    $builder->add('facility');
  }

  public function getName() {
    return 'course';
  }
}
