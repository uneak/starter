<?php

namespace Uneak\PortoAdminBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * APIRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class APIRepository extends EntityRepository {

    public function getFilter(array $filters) {
        $qb = $this->getFilterQuery($filters);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getFilterQuery(array $filters) {
        $qb = $this->createQueryBuilder('o');
        $this->addFilters($qb, $filters, 'o');
        $this->addSelect($qb, $filters, 'o');
        $this->addLimits($qb, $filters, 'o');
        $this->addOrder($qb, $filters, 'o');
        return $qb;
    }

    public function getCount(array $filters = null) {
        $qb = $this->createQueryBuilder('o');

        if ($filters) {
            $this->addFilters($qb, $filters, 'o');
        }
        $qb->select('COUNT(o)');
        return $qb->getQuery()->getSingleScalarResult();
    }



    public function addSelect(QueryBuilder &$qb, array $filters, $alias = "o") {

        if (isset($filters['fields']) && $filters['fields']) {
            $select = array();
            $fields = explode(',', $filters['fields']);
            foreach ($fields as $field) {
                $select[] = $alias . '.' . $field;
            }

            $qb->select(join(',', $select));
        }

    }


    public function addLimits(QueryBuilder &$qb, array $filters) {

        if (isset($filters['offset']) && $filters['offset']) {
            $qb->setFirstResult($filters['offset']);
        }

        if (isset($filters['limit']) && $filters['limit']) {
            $qb->setMaxResults($filters['limit']);
        }

    }


    public function addOrder(QueryBuilder &$qb, array $filters, $alias = "o")
    {
        if (isset($filters['sort']) && $filters['sort']) {
            $fields = explode(',', $filters['sort']);
            foreach ($fields as $field) {
                preg_match("/(-|\\+)(.*)/", $field, $fieldSort);
                $qb->addOrderBy($alias . '.' . $fieldSort[2], ($fieldSort[1] == "+") ? "ASC" : "DESC");
            }
        }
    }


    public function addFilters(QueryBuilder &$qb, array $filters, $alias = "o") {


        $colFilters = new Expr\Andx();

        if (isset($filters['like'])) {
            foreach ($filters['like'] as $col => $val) {
                $filterLabel = $col . '_filter_like_';
                $colFilters->add($qb->expr()->like($alias . '.' . $col, ':' . $filterLabel));
                $qb->setParameter($filterLabel, $val);
            }
        }

        if (isset($filters['eq'])) {
            foreach ($filters['eq'] as $col => $val) {
                $filterLabel = $col . '_filter_eq_';
                $colFilters->add($qb->expr()->eq($alias . '.' . $col, ':' . $filterLabel));
                $qb->setParameter($filterLabel, $val);
            }
        }

        if (isset($filters['ne'])) {
            foreach ($filters['ne'] as $col => $val) {
                $filterLabel = $col . '_filter_ne_';
                $colFilters->add($qb->expr()->neq($alias . '.' . $col, ':' . $filterLabel));
                $qb->setParameter($filterLabel, $val);
            }
        }

        if (isset($filters['lt'])) {
            foreach ($filters['lt'] as $col => $val) {
                $filterLabel = $col . '_filter_lt_';
                $colFilters->add($qb->expr()->lt($alias . '.' . $col, ':' . $filterLabel));
                $qb->setParameter($filterLabel, $val);
            }
        }

        if (isset($filters['gt'])) {
            foreach ($filters['gt'] as $col => $val) {
                $filterLabel = $col . '_filter_gt_';
                $colFilters->add($qb->expr()->gt($alias . '.' . $col, ':' . $filterLabel));
                $qb->setParameter($filterLabel, $val);
            }
        }

        if (isset($filters['le'])) {
            foreach ($filters['le'] as $col => $val) {
                $filterLabel = $col.'_filter_le_';
                $colFilters->add($qb->expr()->lte($alias . '.'.$col, ':'.$filterLabel));
                $qb->setParameter($filterLabel, $val);
            }
        }

        if (isset($filters['ge'])) {
            foreach ($filters['ge'] as $col => $val) {
                $filterLabel = $col.'_filter_ge_';
                $colFilters->add($qb->expr()->gte($alias . '.'.$col, ':'.$filterLabel));
                $qb->setParameter($filterLabel, $val);
            }
        }

        if ($colFilters->count()) {
            $qb->andWhere($colFilters);
        }

    }

}
