<?php
namespace Volleyball\PasselBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AttendeeRepository extends EntityRepository
{
    public function search($query, $field = 'lastname')
    {
        $q = $this->createQueryBuilder('a');
        $q->where('a.'.$field.' LIKE :query')
                ->setParameter('query', '%'.$query.'%');
        
        return $q->getQuery()->getResult();
    }
}
