<?php
namespace Volleyball\PasselBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PasselRepository extends EntityRepository
{
    public function search($query, $field = 'name')
    {
        $q = $this->createQueryBuilder('f');
        $q->where('f.'.$field.' LIKE :query')
                ->setParameter('query', '%'.$query.'%');
        
        return $q->getQuery()->getResult();
    }
}
