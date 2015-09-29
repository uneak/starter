<?php

	namespace Uneak\OAuthClientBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Routing\Annotation\Route;
	use Uneak\OAuthClientBundle\Event\OAuthAutenticationActionEvent;
	use Uneak\OAuthClientBundle\Event\OAuthAutenticationRequestEvent;
	use Uneak\OAuthClientBundle\Event\OAuthAutenticationResponseEvent;

	use Uneak\OAuthClientBundle\OAuth\Token;

	class OAuthController extends Controller {

		/**
		 * @Route("/authentication/code/request/{service}/{action}", name="oauth_authentication_code_request")
		 */

		public function authenticationCodeRequestAction($service, $action) {
			$event = new OAuthAutenticationRequestEvent($service, $action);
			$this->get('event_dispatcher')->dispatch('oauth.autentication.request', $event);

			return $this->redirect($event->getAuthentication());
		}


		/**
		 * @Route("/authentication/code/response/{service}", name="oauth_authentication_code_response")
		 */

		public function authenticationCodeResponseAction($service, Request $request) {
			$event = new OAuthAutenticationResponseEvent($service);
			$this->get('event_dispatcher')->dispatch('oauth.autentication.response', $event);
			$event = new OAuthAutenticationActionEvent($event->getService(), $event->getServiceAlias(), $event->getAction());
			$this->get('event_dispatcher')->dispatch('oauth.autentication.action.' . $event->getAction(), $event);

			return $event->getResponse();
		}
	}
