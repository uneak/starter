<?php

	namespace Uneak\PortoAdminBundle\Blocks\Form;


	use Symfony\Component\Form\FormView;
	use Uneak\PortoAdminBundle\Blocks\Block;

	class Form extends Block {

		protected $templateAlias = "block_template_form";

		protected $formView;

		public function __construct(FormView $formView) {
			parent::__construct();
			$this->setFormView($formView);
		}

		/**
		 * @return mixed
		 */
		public function getFormView() {
			return $this->formView;
		}

		/**
		 * @param mixed $form
		 */
		public function setFormView($formView) {
			$this->formView = $formView;

			return $this;
		}


	}
