<?php

	namespace Uneak\PortoAdminBundle\Blocks\Form;


	use Uneak\PortoAdminBundle\Blocks\Block;

	class Form extends Block {

		protected $templateAlias = "block_template_form";

		protected $form;

		public function __construct($form) {
			parent::__construct();
			$this->setForm($form);
		}

		/**
		 * @return mixed
		 */
		public function getForm() {
			return $this->form;
		}

		/**
		 * @param mixed $form
		 */
		public function setForm($form) {
			$this->form = $form;

			return $this;
		}


	}
