<?php
	namespace Uneak\PortoAdminBundle\Exception;

	use Symfony\Component\Form\FormInterface;
    use Symfony\Component\HttpFoundation\Response;

    class InvalidFormException extends APIException {

		protected $form;

		public function __construct($message, FormInterface $form = null) {
			parent::__construct($message, Response::HTTP_BAD_REQUEST);
			$this->form = $form;
		}

		/**
		 * @return array|null
		 */
		public function getForm() {
			return $this->form;
		}

        public function getData() {
            $array = parent::getData();
            $array['errors']['form'] = $this->form;
            return $array;
        }

	}