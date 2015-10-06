<?php
	namespace Acme\BlogBundle\Exception;

	use Symfony\Component\Form\FormInterface;

	class InvalidFormException extends \RuntimeException {

		protected $form;

		public function __construct($message, FormInterface $form = null) {
			parent::__construct($message);
			$this->form = $form;
		}

		/**
		 * @return array|null
		 */
		public function getForm() {
			return $this->form;
		}
	}