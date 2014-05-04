<?php
namespace Volleyball\Bundle\CourseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Volleyball\Bundle\CourseBundle\Entity\MeritBadge;

class MeritBadgeType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('name');
    $builder->add('special');
  }

  public function getName() {
    return 'merit_badge';
  }
}
