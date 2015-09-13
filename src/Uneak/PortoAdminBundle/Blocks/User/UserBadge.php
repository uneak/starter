<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class UserBadge extends Block {

        protected $templateAlias = "block_template_user_badge";
        protected $user;

        public function __construct($user = null) {
            parent::__construct();
            $this->user = $user;
        }

        public function getUser() {
            return $this->user;
        }

        public function setUser($user) {
            $this->user = $user;
        }


	}
