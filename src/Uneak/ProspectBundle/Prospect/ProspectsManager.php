<?php

	namespace Uneak\ProspectBundle\Prospect;

	use Uneak\FieldBundle\Entity\Field;
	use Uneak\FieldDataBundle\Entity\FieldData;

    use Uneak\FieldTypeBundle\Field\FieldTypesManager;
    use Uneak\ProspectBundle\Entity\Prospect;
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Query\Expr\Join;
	use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
	use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
	use Uneak\FieldBundle\Field\FieldsManager;
	use Uneak\FieldDataBundle\FieldData\FieldDatasManager;


	class ProspectsManager implements UserProviderInterface {

		/**
		 * @var \Doctrine\ORM\EntityManager
		 */
		private $em;
		/**
		 * @var FieldTypesManager
		 */
		private $fieldTypesManager;
		/**
		 * @var FieldDatasManager
		 */
		private $fieldDatasManager;


		public function __construct(EntityManager $em, FieldTypesManager $fieldTypesManager, FieldDatasManager $fieldDatasManager) {
			$this->em = $em;
			$this->fieldTypesManager = $fieldTypesManager;
			$this->fieldDatasManager = $fieldDatasManager;
		}



        public function findProspectsFieldsByGroup($group = null) {

            $qb = $this->em->createQueryBuilder();
            $qb->select('field');
            $qb->from('UneakFieldBundle:Field', 'field');
            $qb->leftJoin('UneakFieldDataBundle:FieldData', 'fieldData', Join::WITH, $qb->expr()->eq('fieldData.field', 'field'));

            if ($group) {
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
                $qb->setParameter("groupSlug", $group);
            }

            $qb->orderBy("field.sort", "ASC");



            return $qb->getQuery()->getResult();
        }






		public function getProspectsArray(array $criteria = array()) {
			$qb = $this->qbProspectBy($criteria);
			$qb->select('prospect, fieldData, field');
			$arrayResults = $qb->getQuery()->getArrayResult();

			$prospectsArray = array();

			foreach ($arrayResults as $arrayResult) {
				$prospect = array();
				$prospect['id'] = $arrayResult['id'];
				$prospect['code'] = $arrayResult['code'];
				$prospect['enabled'] = $arrayResult['enabled'];
				$prospect['createdAt'] = $arrayResult['createdAt'];
				$prospect['updatedAt'] = $arrayResult['updatedAt'];
				foreach ($arrayResult['fieldDatas'] as $arrayResultFields) {
					$prospect[$arrayResultFields['field']['slug']] = $arrayResultFields['value'];
				}

				$prospectsArray[] = $prospect;
			}

			return $prospectsArray;
		}

        protected function qbProspectBy(array $criteria = array()) {

            $fieldDatas = $this->fieldDatasManager->getFieldDatas();

            $qb = $this->em->createQueryBuilder();
            $qb->select('field.slug, field.type');
            $qb->from('UneakFieldBundle:Field', 'field');
            $dbFields = $qb->getQuery()->getArrayResult();

            $fields = array();
            foreach ($dbFields as $field) {
                $fields[$field['slug']] = $field['type'];
            }

            $qb = $this->em->createQueryBuilder();
            $qb->select('prospect');
            $qb->from('UneakProspectBundle:Prospect', 'prospect');
            $qb->leftJoin('prospect.fieldDatas', 'fieldData');
            $qb->leftJoin('fieldData.field', 'field');
            $qb->leftJoin('field.group', 'fieldGroup');

            foreach ($fieldDatas as $fieldData) {
                $qb->leftJoin($fieldData['class'], 'fd_'.$fieldData['alias'], Join::WITH, $qb->expr()->eq('fieldData.id', 'fd_'.$fieldData['alias'].'.id'));
            }

            $andX = $qb->expr()->andX();
            $cmpt = 0;
            foreach ($criteria as $key => $value) {
                if ($key == 'group') {
                    $andX->add($qb->expr()->eq('fieldGroup.slug', ':group_slug_'.$cmpt));
                    $qb->setParameter('group_slug_'.$cmpt, $value);
                } else {
                    $andX->add($qb->expr()->eq('field.slug', ':field_slug_'.$cmpt));
                    $qb->setParameter('field_slug_'.$cmpt, $key);

                    $andX->add($qb->expr()->eq('fd_'.$fields[$key].'.value', ':field_value_'.$cmpt));
                    $qb->setParameter('field_value_'.$cmpt, $value);
                }
                $cmpt++;
            }

            if ($andX->count()) {
                $qb->where($andX);
            }


            return $qb;
        }

        public function findFieldsByProspects(array $prospectsId) {
            $qb = $this->em->createQueryBuilder();
            $qb->select('field');
            $qb->from('UneakFieldBundle:Field', 'field');
            $qb->leftJoin('UneakFieldDataBundle:FieldData', 'fieldData', Join::WITH, $qb->expr()->eq('fieldData.field', 'field'));
            $qb->innerJoin('fieldData.prospect', 'prospect');
            $qb->where($qb->expr()->in('prospect.id', $prospectsId));
            $qb->orderBy("field.sort", "ASC");

            return $qb->getQuery()->getResult();
        }



















		public function findProspectByFieldset($group) {
			$qb = $this->em->createQueryBuilder();
			$qb->select('prospect');
			$qb->distinct(true);
			$qb->from('UneakProspectBundle:Prospect', 'prospect');
			$qb->innerJoin('prospect.fields', 'fieldData');
			$qb->innerJoin('fieldData.field', 'field');
			$qb->innerJoin('field.group', 'fieldGroup');
			$qb->where($qb->expr()->eq('fieldGroup.slug', ':group'));
			$qb->setParameter("group", $group);

			return $qb->getQuery()->getResult();
		}



		protected function _generateCode() {
			$string = time().uniqid();

			$data = base64_encode($string);
			$no_of_eq = substr_count($data, "=");
			$data = str_replace("=", "", $data);
			$data = $data . $no_of_eq;
			$data = str_replace(array('+', '/'), array('-', '_'), $data);
			return $data;
		}

		protected function _findFields($group) {
			$qb = $this->em->createQueryBuilder();
			$qb->select('field');
			$qb->from('UneakFieldBundle:Field', 'field');
			$qb->leftJoin('field.group', 'fieldGroup');
			$qb->where($qb->expr()->eq('fieldGroup.slug', ':group'));
			$qb->setParameter('group', $group);
			$qb->orderBy("field.sort", "ASC");
			return $qb->getQuery()->getResult();
		}



		public function setField(Prospect $prospect, $fieldSlug, $value = null) {
			if ($prospect->hasField($fieldSlug)) {
				$prospect->setField($fieldSlug, $value);

			} else {

				$qb = $this->em->createQueryBuilder();
				$qb->select('field');
				$qb->from('UneakFieldBundle:Field', 'field');
				$qb->where($qb->expr()->eq('field.slug', ':fieldSlug'));
				$qb->setParameter('fieldSlug', $fieldSlug);
				$field = $qb->getQuery()->getOneOrNullResult();

				if (!$field) {
					// TODO: exeption
					throw new \Exception("Le champ ".$fieldSlug." n'existe pas");
				}

				$fieldInfo = $this->fieldTypesManager->getFieldType($field->getType());
				$fieldDataClass = $this->fieldDatasManager->getFieldDataClass($fieldInfo['field_data']);
				$fieldData = new $fieldDataClass($field, $value);
				$prospect->addFieldData($fieldData);
			}
			return $prospect;
		}

		public function createProspect($group = null) {
			$prospect = new Prospect();
			$prospect->setCode($this->_generateCode());

			if ($group) {
				$fields = $this->_findFields($group);
				/** @var $field Field */
				foreach ($fields as $field) {
					$fieldInfo = $this->fieldTypesManager->getFieldType($field->getType());
					$fieldDataClass = $this->fieldDatasManager->getFieldDataClass($fieldInfo['field_data']);
					$fieldData = new $fieldDataClass($field);
					$prospect->addFieldData($fieldData);
				}
			}

			return $prospect;
		}


		public function removeProspect(Prospect $prospect, $andFlush = true) {
			$this->em->remove($prospect);
			if ($andFlush) {
				$this->em->flush();
			}
			return $this;
		}


		public function saveProspect(Prospect $prospect, $andFlush = true) {
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




		public function findProspectByCode($code) {
			$repository = $this->em->getRepository('UneakProspectBundle:Prospect');
			return $repository->findOneBy(array('code' => $code));
		}

		public function findProspectById($id) {
			$repository = $this->em->getRepository('UneakProspectBundle:Prospect');
			return $repository->findOneBy(array('id' => $id));
		}

		public function findProspectBy(array $criteria = array()) {
			$qb = $this->qbProspectBy($criteria);
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
		public function loadUserByUsername($username) {

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
		public function refreshUser(UserInterface $user) {
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
		public function supportsClass($class) {
			return 'Uneak\ProspectBundle\Entity\Prospect' === $class || is_subclass_of($class, 'Uneak\ProspectBundle\Entity\Prospect');
		}


	}
