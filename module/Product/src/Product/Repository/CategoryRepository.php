<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 23/7/2015
 * Time: 1:55 πμ
 */

namespace Product\Repository;


use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class CategoryRepository extends EntityRepository{

    public function search($value, $page = 1, $count = null, $sort = null)
    {
        if (!empty($value)) {
            $qb = $this->createQueryBuilder('c');
            $qb->where($qb->expr()->like('c.name', '?1'))
                ->orWhere($qb->expr()->like('c.position', '?2'))
                ->setParameter(1, $value . '%')
                ->setParameter(2, $value . '%');

            if($sort) $qb->orderBy("c.".$sort["column"],$sort["type"]);


            $paginator = new Paginator(new DoctrineAdapter(new ORMPaginator($qb)));
            if($count) $paginator->setDefaultItemCountPerPage($count);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } else {
            throw new \InvalidArgumentException("The category's name can't be empty.");
        }
    }

    public function findNameAndId(){
        $qb = $this->createQueryBuilder('c')
            ->select('c.categoryId as id, c.name as value');

        $resultArray = [];
        foreach($qb->getQuery()->getResult() as $result){
            $resultArray[$result["id"]] = $result["value"];
        }

        return $resultArray;
    }
}