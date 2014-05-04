<?php
namespace Volleyball\Bundle\PasselBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PositionRepository extends EntityRepository
{
    public function search($query, $field = 'name')
    {
        $q = $this->createQueryBuilder('f');
        $q->where('f.'.$field.' LIKE :query')
                ->setParameter('query', '%'.$query.'%');
        
        return $q->getQuery()->getResult();
    }
}
