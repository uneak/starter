<?php
	namespace Uneak\PortoAdminBundle\Exception;

    use Symfony\Component\HttpFoundation\Response;

    class APIException extends \RuntimeException {

        public function getData() {
            return array(
                'errors' => array(
                    "code" => $this->getCode(),
                    "code_message" => Response::$statusTexts[$this->getCode()],
                    "message" => $this->getMessage(),
                )
            );
        }
	}