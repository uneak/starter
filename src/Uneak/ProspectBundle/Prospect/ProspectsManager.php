<?php

namespace Uneak\ProspectBundle\Prospect;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldBundle\Field\FieldsHelper;
use Uneak\FieldDataBundle\Entity\FieldData;
use Uneak\FieldDataBundle\FieldData\FieldDataHelper;
use Uneak\FieldTypeBundle\Field\FieldTypesManager;
use Uneak\PortoAdminBundle\Entity\APIQueryInterface;
use Uneak\ProspectBundle\Entity\Prospect;


class ProspectsManager implements UserProviderInterface, APIQueryInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * @var FieldTypesManager
     */
    private $fieldTypesManager;
    /**
     * @var FieldsHelper
     */
    private $fieldsHelper;
    /**
     * @var FieldDataHelper
     */
    private $fieldDataHelper;


    private $baseField = array('id', 'code', 'enabled', 'createdAt', 'updatedAt');


    public function __construct(EntityManager $em, FieldTypesManager $fieldTypesManager, FieldsHelper $fieldsHelper, FieldDataHelper $fieldDataHelper)
    {
        $this->em = $em;
        $this->fieldTypesManager = $fieldTypesManager;
        $this->fieldsHelper = $fieldsHelper;
        $this->fieldDataHelper = $fieldDataHelper;
    }

    /**
     * @return array
     */
    public function getBaseField()
    {
        return $this->baseField;
    }


    public function findProspectsFieldsByGroup($slug = null)
    {

        $qb = $this->em->createQueryBuilder();
        $qb->select('field');
        $qb->from('UneakFieldBundle:Field', 'field');
        $qb->leftJoin('UneakFieldDataBundle:FieldData', 'fieldData', Join::WITH, $qb->expr()->eq('fieldData.field', 'field'));

        if ($slug) {
            $qbProspect = $this->em->createQueryBuilder();
            $qbProspect->select('p_prospect');
            $qbProspect->distinct(true);
            $qbProspect->from('UneakProspectBundle:Prospect', 'p_prospect');
            $qbProspect->innerJoin('p_prospect.fieldDatas', 'p_fieldData');
            $qbProspect->innerJoin('p_fieldData.field', 'p_field');
            $qbProspect->innerJoin('p_field.group', 'p_group');
            $qbProspect->where($qbProspect->expr()->eq('p_group.slug', ':groupSlug'));
            //
            $qb->innerJoin('fieldData.prospect', 'prospect');
            $qb->where($qb->expr()->in('prospect.id', $qbProspect->getDQL()));
            $qb->setParameter("groupSlug", $slug);
        }

        $qb->orderBy("field.sort", "ASC");


        return $qb->getQuery()->getResult();
    }




    public function getCount(array $criteria = array())
    {
        $qb = $this->baseQuery();
        $this->addFilters($qb, $criteria);
        $qb->select('COUNT(DISTINCT prospect)');
        $qb->distinct(false);

//        ldd($qb->getQuery()->getDQL());

       return intval($qb->getQuery()->getSingleScalarResult());
    }


    public function getAll(array $criteria = array())
    {
        $qb = $this->baseQuery();
        $this->addFilters($qb, $criteria);
        $this->addLimits($qb, $criteria);
        $this->addOrder($qb, $criteria);

        $query = $qb->getQuery();

//        ldd($query->getDQL());

        $result = $query->getResult();
        $fields = $this->getFieldsArray($criteria['fields']);


        $prospectsData = array();
        /** @var $prospect Prospect */
        foreach ($result as $prospect) {
            $prospectData = array();
            $data = $prospect->getCache();
            foreach ($fields as $field) {
                $prospectData[$field] = (isset($data[$field])) ? $data[$field] : null;
            }
            $prospectsData[] = $prospectData;
        }

        return $prospectsData;
    }



    protected function baseQuery() {
        $qb = $this->em->createQueryBuilder();
        $qb->select('prospect');
        $qb->distinct(true);
        $qb->from('UneakProspectBundle:Prospect', 'prospect');
        $qb->innerJoin('prospect.fieldDatas', 'fieldData');
        $qb->innerJoin('fieldData.field', 'field');
        $qb->innerJoin('field.group', 'fieldGroup');
        return $qb;
    }


    protected function addJoin(QueryBuilder $qb, $field) {
        $dataName = 'fieldData_' . $field;
        $qb->leftJoin('UneakFieldDataBundle:FieldData', $dataName, Join::WITH, $qb->expr()->andX(
            $qb->expr()->eq($dataName . '.prospect', 'prospect.id')
        ));

        $fieldName = 'field_' . $field;
        $qb->leftJoin('UneakFieldBundle:Field', $fieldName, Join::WITH, $qb->expr()->andX(
            $qb->expr()->eq($fieldName . '.id', $dataName . '.field'),
            $qb->expr()->eq($fieldName . '.slug', ':'.$fieldName.'_join')
        ));
        $qb->setParameter($fieldName.'_join', $field);
    }



    public function addSelect(QueryBuilder &$qb, array $criteria = array(), $alias = "o")
    {

        if (isset($criteria['fields']) && count($criteria['fields'])) {
            $select = array();
            $fields = $this->getFieldsArray($criteria['fields']);

            foreach ($fields as $field) {
                if (in_array($field, $this->getBaseField())) {
                    $select[] = $dataName = 'prospect.' . $field . ' as ' . $field;
                } else {
                    $select[] = 'fieldData_' . $field . '.value' . ' as ' . $field;
                }
            }

            $qb->select(join(',', $select));
        }
    }

    private function getFieldsArray($fields) {
        $fields = explode(',', $fields);
        for ($i = 0; $i<count($fields); $i++) {
            $fields[$i] = trim($fields[$i]);
        }
        return $fields;
    }

    public function addFilters(QueryBuilder &$qb, array $criteria = array(), $alias = "o")
    {
        if (count($criteria) == 0) {
            return;
        }


        $joins = array();

        $colFilters = new Andx();
        $cmpt = 0;

        if (isset($criteria['like'])) {
            foreach ($criteria['like'] as $col => $val) {

                $dataName = 'fieldData_' . $col;

                if (in_array($col, $this->getBaseField())) {
                    $colFilters->add($qb->expr()->like('prospect.' . $col, ':' . $col . '_slug_like_' . $cmpt));
                    $qb->setParameter($col . '_slug_like_' . $cmpt, $val);

                } else if ($col != 'group') {

                    if (!isset($joins[$col])) {
                        $this->addJoin($qb, $col);
                    }

                    $colFilters->add($qb->expr()->like($dataName . '.value', ':field_value_eq_' . $cmpt));
                    $qb->setParameter('field_value_eq_' . $cmpt, $val);

                } else {
                    $colFilters->add($qb->expr()->like('fieldGroup.slug', ':fieldGroup_like_' . $cmpt));
                    $qb->setParameter('fieldGroup_like_' . $cmpt, $val);

                }
                $cmpt++;
            }
        }

        if (isset($criteria['eq'])) {
            foreach ($criteria['eq'] as $col => $val) {

                $dataName = 'fieldData_' . $col;

                if (in_array($col, $this->getBaseField())) {
                    $colFilters->add($qb->expr()->eq('prospect.' . $col, ':' . $col . '_slug_eq_' . $cmpt));
                    $qb->setParameter($col . '_slug_eq_' . $cmpt, $val);

                } else if ($col != 'group') {

                    if (!isset($joins[$col])) {
                        $this->addJoin($qb, $col);
                    }

                    $colFilters->add($qb->expr()->eq($dataName . '.value', ':field_value_eq_' . $cmpt));
                    $qb->setParameter('field_value_eq_' . $cmpt, $val);

                } else {
                    $colFilters->add($qb->expr()->eq('fieldGroup.slug', ':fieldGroup_eq_' . $cmpt));
                    $qb->setParameter('fieldGroup_eq_' . $cmpt, $val);

                }
                $cmpt++;

            }
        }


        if (isset($criteria['ne'])) {
            foreach ($criteria['ne'] as $col => $val) {

                $dataName = 'fieldData_' . $col;

                if (in_array($col, $this->getBaseField())) {
                    $colFilters->add($qb->expr()->neq('prospect.' . $col, ':' . $col . '_slug_ne_' . $cmpt));
                    $qb->setParameter($col . '_slug_ne_' . $cmpt, $val);

                } else if ($col != 'group') {

                    if (!isset($joins[$col])) {
                        $this->addJoin($qb, $col);
                    }

                    $colFilters->add($qb->expr()->neq($dataName . '.value', ':field_value_ne_' . $cmpt));
                    $qb->setParameter('field_value_ne_' . $cmpt, $val);
                }
                $cmpt++;

            }
        }


        if (isset($criteria['lt'])) {
            foreach ($criteria['lt'] as $col => $val) {


                $dataName = 'fieldData_' . $col;

                if (in_array($col, $this->getBaseField())) {
                    $colFilters->add($qb->expr()->lt('prospect.' . $col, ':' . $col . '_slug_lt_' . $cmpt));
                    $qb->setParameter($col . '_slug_lt_' . $cmpt, $val);

                } else if ($col != 'group') {

                    if (!isset($joins[$col])) {
                        $this->addJoin($qb, $col);
                    }

                    $colFilters->add($qb->expr()->lt($dataName . '.value', ':field_value_lt_' . $cmpt));
                    $qb->setParameter('field_value_lt_' . $cmpt, $val);
                }
                $cmpt++;
            }
        }

        if (isset($criteria['gt'])) {
            foreach ($criteria['gt'] as $col => $val) {


                $dataName = 'fieldData_' . $col;

                if (in_array($col, $this->getBaseField())) {
                    $colFilters->add($qb->expr()->gt('prospect.' . $col, ':' . $col . '_slug_gt_' . $cmpt));
                    $qb->setParameter($col . '_slug_gt_' . $cmpt, $val);

                } else if ($col != 'group') {

                    if (!isset($joins[$col])) {
                        $this->addJoin($qb, $col);
                    }

                    $colFilters->add($qb->expr()->gt($dataName . '.value', ':field_value_gt_' . $cmpt));
                    $qb->setParameter('field_value_gt_' . $cmpt, $val);

                }
                $cmpt++;
            }
        }

        if (isset($criteria['le'])) {
            foreach ($criteria['le'] as $col => $val) {


                $dataName = 'fieldData_' . $col;

                if (in_array($col, $this->getBaseField())) {
                    $colFilters->add($qb->expr()->lte('prospect.' . $col, ':' . $col . '_slug_le_' . $cmpt));
                    $qb->setParameter($col . '_slug_le_' . $cmpt, $val);

                } else if ($col != 'group') {

                    if (!isset($joins[$col])) {
                        $this->addJoin($qb, $col);
                    }

                    $colFilters->add($qb->expr()->lte($dataName . '.value', ':field_value_le_' . $cmpt));
                    $qb->setParameter('field_value_le_' . $cmpt, $val);

                }
                $cmpt++;
            }
        }

        if (isset($criteria['ge'])) {
            foreach ($criteria['ge'] as $col => $val) {

                $dataName = 'fieldData_' . $col;

                if (in_array($col, $this->getBaseField())) {
                    $colFilters->add($qb->expr()->gte('prospect.' . $col, ':' . $col . '_slug_ge_' . $cmpt));
                    $qb->setParameter($col . '_slug_ge_' . $cmpt, $val);

                } else if ($col != 'group') {

                    if (!isset($joins[$col])) {
                        $this->addJoin($qb, $col);
                    }

                    $colFilters->add($qb->expr()->gte($dataName . '.value', ':field_value_ge_' . $cmpt));
                    $qb->setParameter('field_value_ge_' . $cmpt, $val);

                }
                $cmpt++;
            }
        }

        if ($colFilters->count()) {
            $qb->andWhere($colFilters);
        }
    }


    public function addLimits(QueryBuilder &$qb, array $criteria = array())
    {
        if (isset($criteria['offset'])) {
            $qb->setFirstResult(intval($criteria['offset']));
        }

        if (isset($criteria['limit']) && $criteria['limit'] != -1) {
            $qb->setMaxResults(intval($criteria['limit']));
        }
    }


    public function addOrder(QueryBuilder &$qb, array $criteria = array(), $alias = "o")
    {
        if (isset($criteria['sort']) && $criteria['sort']) {
            $fields = explode(',', $criteria['sort']);
            foreach ($fields as $field) {
                preg_match("/(-|\\+)(.*)/", $field, $fieldSort);

                if (in_array($fieldSort[2], $this->getBaseField())) {
                    $dataName = 'prospect.' . $fieldSort[2];
                    $qb->addOrderBy($dataName, ($fieldSort[1] == "+") ? "ASC" : "DESC");

                } else {
                    $dataName = 'fieldData_' . $fieldSort[2];
                    $qb->addOrderBy($dataName . '.value', ($fieldSort[1] == "+") ? "ASC" : "DESC");
                }


            }
        }
    }


    protected function _generateCode()
    {
        $string = time() . uniqid();

        $data = base64_encode($string);
        $no_of_eq = substr_count($data, "=");
        $data = str_replace("=", "", $data);
        $data = $data . $no_of_eq;
        $data = str_replace(array('+', '/'), array('-', '_'), $data);
        return $data;
    }


    public function setField(Prospect $prospect, $keyOrField, $value = null)
    {
        try {
            $prospect->setField($keyOrField, $value);
        } catch (\InvalidArgumentException $e) {
            if ($keyOrField instanceof Field) {
                $fieldData = new FieldData();
                $prospect->addFieldData($fieldData);
                $keyOrField->addFieldData($fieldData);

                if ($keyOrField->getType() == FieldDataHelper::TYPE_BOOLEAN) {
                    $value = intval($value);
                }

                $fieldData->setValue($value);
            } else {
                throw new \InvalidArgumentException("Le champs " . $keyOrField . " n'existe pas pour ce prospect");
            }
        }

        return $prospect;
    }



    public function setGroupField(Prospect $prospect, $group, $key, $value = null)
    {
        $field = $this->fieldsHelper->findFieldBy(array('group' => $group, 'slug' => $key));
        if (!$field) {
            throw new \InvalidArgumentException("Le champs " . $field . " n'existe pas pour ce prospect");
        }
        $this->setField($prospect, $field, $value);
        return $prospect;
    }


    public function createProspect($group = null)
    {
        $prospect = new Prospect();
        $prospect->setCode($this->_generateCode());

        if ($group) {
            $fields = $this->fieldsHelper->findFieldsByGroup($group);
            foreach ($fields as $field) {
                $this->fieldDataHelper->createFieldData($field, $prospect);
            }
        }

        return $prospect;
    }


    public function removeProspect(Prospect $prospect, $andFlush = true)
    {
        $this->em->remove($prospect);
        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }


    public function saveProspect(Prospect $prospect, $andFlush = true)
    {
        $this->em->persist($prospect);

        $fieldDatas = $prospect->getFieldDatas();
        /** @var $fieldData FieldData */
        foreach ($fieldDatas as $fieldData) {
            $this->em->persist($fieldData);
        }

        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }


    public function findProspectByCode($code)
    {
        $repository = $this->em->getRepository('UneakProspectBundle:Prospect');
        return $repository->findOneBy(array('code' => $code));
    }

    public function findProspectById($id)
    {
        $repository = $this->em->getRepository('UneakProspectBundle:Prospect');
        return $repository->findOneBy(array('id' => $id));
    }

    public function findProspectBy(array $criteria = array())
    {
        $qb = $this->baseQuery();
        $this->addFilters($qb, $criteria);
        $this->addLimits($qb, $criteria);
        $this->addOrder($qb, $criteria);

        return $qb->getQuery()->getResult();
    }


    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @see UsernameNotFoundException
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {

        $user = $this->findProspectByCode($username);
        if (null === $user) {
            $message = sprintf(
                'Unable to find an active prospect object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message);
        }

        return $user;

    }


    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        /** @var $user Prospect */
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        $refreshedUser = $this->loadUserByUsername($user->getCode());
        if (null === $refreshedUser) {
            throw new UsernameNotFoundException(sprintf('User with username "%d" could not be reloaded.', $user->getUsername()));
        }

        return $refreshedUser;

    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return 'Uneak\ProspectBundle\Entity\Prospect' === $class || is_subclass_of($class, 'Uneak\ProspectBundle\Entity\Prospect');
    }

}
