<?php
namespace Volleyball\FacilityBundle\Entity;

class PasselQuarters extends Quarters
{
    public function __construct()
    {
        $this->setType('passel');
    }
}
