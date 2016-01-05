<?php

	namespace AppBundle\Sluggable;

	class SluggableListener extends \Gedmo\Sluggable\SluggableListener{

		public function __construct(){
			$this->setTransliterator(array('\Your\Bundle\Misc\Transliterator', 'transliterate'));
		}
		protected function getNamespace()
		{
			return parent::getNamespace();
		}

	}