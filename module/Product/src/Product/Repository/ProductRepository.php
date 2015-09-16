<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 19/6/2014
 * Time: 12:15 πμ
 */

namespace Product\Repository;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class ProductRepository extends EntityRepository
{
    public function findAssoc()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.productId as id, p.productNumber as value')
            ->orderBy("p.productId", "DESC");

        $resultArray = [];
        foreach ($qb->getQuery()->getResult() as $result) {
            $resultArray[$result["id"]] = $result["value"];
        }

        return $resultArray;
    }

    public function findByFilters($options)
    {
        $qb = $this->createQueryBuilder('p');
        $search = trim($options['search']);
        if (!empty($search)) {
            $qb->where($qb->expr()->like('p.name', '?1'))
                ->orWhere($qb->expr()->like('p.productNumber', '?2'))
                ->setParameter(1, $search . '%')
                ->setParameter(2, $search . '%');
        }

        if ($options['sort']) $qb->orderBy("p." . $options['sort']["column"], $options['sort']["type"]);

        $paginator = new Paginator(new DoctrineAdapter(new ORMPaginator($qb)));
        if ($options['limit']) $paginator->setDefaultItemCountPerPage($options['limit']);
        $paginator->setCurrentPageNumber($options['page']);

        return $paginator;
    }

    public function searchAll($value)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where($qb->expr()->like('p.name', '?1'))
            ->orWhere($qb->expr()->like('p.productNumber', '?2'))
            ->setParameter(1, $value . '%')
            ->setParameter(2, $value . '%');

        return $qb->getQuery()->getResult();
    }

    public function search($value, $page = 1, $count = null, $sort = null)
    {
        if (!empty($value)) {
            $qb = $this->createQueryBuilder('p');
            $qb->where($qb->expr()->like('p.name', '?1'))
                ->orWhere($qb->expr()->like('p.productNumber', '?2'))
                ->setParameter(1, $value . '%')
                ->setParameter(2, $value . '%');

            if ($sort) $qb->orderBy("p." . $sort["column"], $sort["type"]);


            $paginator = new Paginator(new DoctrineAdapter(new ORMPaginator($qb)));
            if ($count) $paginator->setDefaultItemCountPerPage($count);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } else {
            throw new \InvalidArgumentException("The product's name can't be empty.");
        }
    }

    public function count()
    {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p.productId)');
        $query = $query->getQuery();
        return $query->getSingleScalarResult();


    }
} 