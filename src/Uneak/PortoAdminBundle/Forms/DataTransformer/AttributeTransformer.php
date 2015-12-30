<?php

	namespace Uneak\PortoAdminBundle\Forms\DataTransformer;

	use Symfony\Component\Form\DataTransformerInterface;

	class AttributeTransformer implements DataTransformerInterface {

		public function transform($data) {
			return $data;
		}

		public function reverseTransform($data) {
			$array = array();
			foreach ($data as $value) {
				$array[$value['key']] = $value['value'];
			}

			return $array;
		}

	}
