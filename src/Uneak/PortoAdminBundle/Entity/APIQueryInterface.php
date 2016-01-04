<?php

namespace Uneak\PortoAdminBundle\Entity;


use Doctrine\ORM\QueryBuilder;

interface APIQueryInterface {

    public function getAll(array $criteria = array());
    public function getCriteriaQuery(array $criteria = array());
    public function getCount(array $criteria = array());

    public function addSelect(QueryBuilder &$qb, array $criteria = array(), $alias = "o");
    public function addLimits(QueryBuilder &$qb, array $criteria = array());
    public function addOrder(QueryBuilder &$qb, array $criteria = array(), $alias = "o");
    public function addFilters(QueryBuilder &$qb, array $criteria = array(), $alias = "o");
}