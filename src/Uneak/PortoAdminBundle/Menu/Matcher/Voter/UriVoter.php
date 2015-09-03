<?php

	namespace Uneak\PortoAdminBundle\Menu\Matcher\Voter;

	use Knp\Menu\ItemInterface;
	use Knp\Menu\Matcher\Voter\VoterInterface;
	use Symfony\Component\HttpFoundation\Request;


	class UriVoter implements VoterInterface {

		private $request;

		public function __construct(Request $request = null) {
			$this->request = $request;
		}

		public function setRequest(Request $request) {
			$this->request = $request;
		}

		public function matchItem(ItemInterface $item) {

			$uri = $this->request->getRequestUri();

			if (null === $uri || null === $item->getUri()) {
				return null;
			}

			if ($item->getUri() === $uri) {
				return true;
			}

			return null;
		}
	}
