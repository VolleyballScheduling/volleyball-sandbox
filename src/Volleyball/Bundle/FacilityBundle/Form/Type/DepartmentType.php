<?php
namespace Volleyball\Bundle\FacilityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Volleyball\Bundle\FacilityBundle\Entity\Department;

class DepartmentType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('name');
    $builder->add('parent');
    $builder->add('facility');
  }

  public function getName() {
    return 'department';
  }
}
