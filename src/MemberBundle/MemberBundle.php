<?php

	namespace MemberBundle;

	use Symfony\Component\HttpKernel\Bundle\Bundle;

	class MemberBundle extends Bundle {
		public function getParent() {
			return 'FOSUserBundle';
		}
	}
