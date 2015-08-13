<?php
namespace User\Repository;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class UserRepository extends EntityRepository{
    public function search($value, $page = 1, $count = null, $sort = null)
    {
        if (!empty($value)) {
            $qb = $this->createQueryBuilder('u');
            $qb->where($qb->expr()->like('u.username', '?1'))
                ->orWhere($qb->expr()->like('u.email', '?2'))
                ->setParameter(1, $value . '%')
                ->setParameter(2, $value . '%');

            if($sort) $qb->orderBy("p.".$sort["column"],$sort["type"]);


            $paginator = new Paginator(new DoctrineAdapter(new ORMPaginator($qb)));
            if($count) $paginator->setDefaultItemCountPerPage($count);
            $paginator->setCurrentPageNumber($page);

            $paginator->getPages()->pageCount;

            return $paginator;
        } else {
            throw new \InvalidArgumentException("The search value can't be empty.");
        }
    }
}