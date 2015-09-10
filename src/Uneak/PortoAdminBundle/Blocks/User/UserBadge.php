<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class UserBadge extends BlockModel {

        protected $templateAlias = "block_template_user_badge";
        protected $user;

        public function __construct($user = null) {
            $this->user = $user;
        }

        public function getUser() {
            return $this->user;
        }

        public function setUser($user) {
            $this->user = $user;
        }


	}
