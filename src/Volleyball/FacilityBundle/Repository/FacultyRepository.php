<?php
namespace Volleyball\FacilityBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FacultyRepository extends EntityRepository
{
    public function filterByFacility($facility)
    {
        if (!$facility instanceof Volleyball\FacillityBundle\Entity\Faculty) {
            throw new \InvalidArgumentException('argument must be of type Faculty');
        }
        $query = 'SELECT f FROM VolleyballFacilityBundle:Faculty f where f.facility_id = :id';

        return $this->getEntityManager()->createQuery($query)->setParameter('id', $facility->getId())->getResult();
    }
}
