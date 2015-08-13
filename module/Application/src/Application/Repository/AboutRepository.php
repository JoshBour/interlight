<?php
namespace Application\Repository;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class AboutRepository extends EntityRepository{
    public function search($value, $page = 1, $count = null, $sort = null)
    {
        if (!empty($value)) {
            $qb = $this->createQueryBuilder('a');
            $qb->where($qb->expr()->like('a.title', '?1'))
                ->setParameter(1, $value . '%');

            if($sort) $qb->orderBy("a.".$sort["column"],$sort["type"]);


            $paginator = new Paginator(new DoctrineAdapter(new ORMPaginator($qb)));
            if($count) $paginator->setDefaultItemCountPerPage($count);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } else {
            throw new \InvalidArgumentException("The slide's name can't be empty.");
        }
    }
}