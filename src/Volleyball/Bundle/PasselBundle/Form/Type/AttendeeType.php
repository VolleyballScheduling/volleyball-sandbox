<?php
namespace Volleyball\Bundle\PasselBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class AttendeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name');
        $builder->add('last_name');

        $minYr = date('Y') - 18;
        $maxYr = date('Y') - 10;
        $years = array();

        for($x=$maxYr; $x >= $minYr; $x--)  $years[] = $x;

        $builder->add('birthdate',   'birthday', array('years' => $years, 'format' => 'M/dd/y'));
        $builder->add('faction',   'entity',   array('property' =>  'name', 'class' => 'Volleyball\Bundle\PasselBundle\Entity\Faction'));
        $builder->add('passel',  'entity',   array('property' =>  'name', 'class' => 'Volleyball\Bundle\PasselBundle\Entity\Passel'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Volleyball\Bundle\PasselBundle\Entity\Attendee'
       ));
    }

    public function getName()
    {
        return 'attendee';
    }
}
