<?php

namespace OAuthServerBundle\Entity;

use AppBundle\Traits\DesignationableEntity;
use AppBundle\VichUploader\Traits\ImageableEntity;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


/**
 * Client
 *
 * @ORM\Table(name="OAuthServerClient")
 * @ORM\Entity
 * 
 * @Uploadable
 */
class Client extends BaseClient {

	use TimestampableEntity;
	use ImageableEntity;
	use DesignationableEntity;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;



	public function __construct() {
		parent::__construct();
	}


}
