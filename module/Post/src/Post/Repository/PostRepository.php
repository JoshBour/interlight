<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 19/6/2014
 * Time: 12:15 πμ
 */

namespace Post\Repository;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;


class PostRepository extends EntityRepository{
    public function search($value, $page = 1, $count = null, $sort = null)
    {
        if (!empty($value)) {
            $qb = $this->createQueryBuilder('p');
            $qb->where($qb->expr()->like('p.title', '?1'))
                ->setParameter(1, $value . '%');

            if($sort) $qb->orderBy("p.".$sort["column"],$sort["type"]);


            $paginator = new Paginator(new DoctrineAdapter(new ORMPaginator($qb)));
            if($count) $paginator->setDefaultItemCountPerPage($count);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } else {
            throw new \InvalidArgumentException("The post's name can't be empty.");
        }
    }

    public function count()
    {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p.postId)');
        $query = $query->getQuery();
        return $query->getSingleScalarResult();


    }
} 