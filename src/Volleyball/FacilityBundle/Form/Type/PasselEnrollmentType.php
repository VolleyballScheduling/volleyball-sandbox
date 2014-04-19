<?php
namespace Volleyball\FacilityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PasselEnrollmentType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('group');
    $builder->add('facility');
    $builder->add('week');
  }

  public function getName()
  {
    return 'passel_enrollment';
  }
}
