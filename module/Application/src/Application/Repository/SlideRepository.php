<?php
namespace Application\Repository;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class SlideRepository extends EntityRepository{
    public function search($value, $page = 1, $count = null, $sort = null)
    {
        if (!empty($value)) {
            $qb = $this->createQueryBuilder('s');
            $qb->where($qb->expr()->like('s.url', '?1'))
                ->orWhere($qb->expr()->like('s.position', '?2'))
                ->setParameter(1, $value . '%')
                ->setParameter(2, $value . '%');

            if($sort) $qb->orderBy("s.".$sort["column"],$sort["type"]);


            $paginator = new Paginator(new DoctrineAdapter(new ORMPaginator($qb)));
            if($count) $paginator->setDefaultItemCountPerPage($count);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } else {
            throw new \InvalidArgumentException("The slide's name can't be empty.");
        }
    }
}