<?php

	namespace Uneak\PortoAdminBundle\Blocks\Photo;


    use Uneak\PortoAdminBundle\Blocks\Block;

    class Photo extends Block {

        protected $templateAlias = "block_template_photo";
		protected $title;
		protected $description;
		protected $photo;

		public function __construct() {
            parent::__construct();
		}

        /**
         * @return mixed
         */
        public function getTitle()
        {
            return $this->title;
        }

        /**
         * @param mixed $title
         */
        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * @return mixed
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description)
        {
            $this->description = $description;
        }

        /**
         * @return mixed
         */
        public function getPhoto()
        {
            return $this->photo;
        }

        /**
         * @param mixed $photo
         */
        public function setPhoto($photo)
        {
            $this->photo = $photo;
        }





	}
