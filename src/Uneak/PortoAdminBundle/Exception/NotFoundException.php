<?php
	namespace Uneak\PortoAdminBundle\Exception;

    use Symfony\Component\HttpFoundation\Response;

    class NotFoundException extends APIException {

		protected $id;

		public function __construct($message, $id = null) {
			parent::__construct($message, Response::HTTP_NOT_FOUND);
			$this->id = $id;
		}

        public function getId()
        {
            return $this->id;
        }

	}