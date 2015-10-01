<?php

	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\MaterialDesignBundle\Blocks\CardBlock;
    use Uneak\OAuthClientBundle\OAuth\Authentication;
	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfiguration;
	use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfiguration;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1Configuration;
	use Uneak\OAuthClientBundle\OAuth\OAuth1;
	use Uneak\OAuthClientBundle\OAuth\ServerFactory;
	use Uneak\OAuthClientBundle\OAuth\Signature\HmacSha1Signature;
	use Uneak\OAuthClientBundle\OAuth\Signature\PlainTextSignature;
	use Uneak\OAuthClientBundle\Server\FacebookServer;
    use Uneak\OAuthClientBundle\OAuth\Credentials;
    use Uneak\OAuthClientBundle\OAuth\Server;
	use Uneak\PortoAdminBundle\Blocks\Layout\Header;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
	use UserBundle\Entity\User;

	class DefaultController extends Controller {

		/**
		 * @Route("/test", name="test")
		 */
		public function testAction() {

			$credentials = new CredentialsConfiguration(array(
				'clientId'        => "wWw1hP1RbJgjC6LyS9QmY3aKv",
				'clientSecret'    => "7DXjAi9KGq7SbXvuFjWF4qVAJARUE7mNzodub2Q0VMWbmafDkz",
			));

			$server = new ServerOAuth1Configuration(array(
				'request_token_url'  => "https://api.twitter.com/oauth/request_token",
				'access_token_url' => "https://api.twitter.com/oauth/access_token",
				'authorize_url' => "https://api.twitter.com/oauth/authorize",
			));

			$auth = new AuthenticationConfiguration(array(
				'redirect_uri'  => "http://dev.starter.com/app_dev.php/authentication/code/response/twitter",
			));


			$requestToken = OAuth1::getRequestToken($credentials, $server, $auth, new HmacSha1Signature());

			ldd($requestToken);

		}


		/**
		 * @Route("/", name="homepage")
		 */
		public function indexAction() {

//			$templateManager = $this->get("uneak.templatesmanager");
//			ldd($templateManager->all());
//
//			$blockManager = $this->get("uneak.blocksmanager");
//
//			$cardBlock = new CardBlock();
//			$cardBlock->setTitle("Marc1");
//			$cardBlock->setTitleColor("#FFF");
//			$cardBlock->setDescription("Marc Galoyer Developpeur web");
//			$cardBlock->setBackground("/apple-touch-icon.png");
//			$cardBlock->setBackgroundHeight("200px");
//			$cardBlock->setWidth("300px");
//			$cardBlock->setHeight("300px");
//			$blockManager->addBlock($cardBlock, 'card1');
//
//
//			$cardBlock = new CardBlock();
//			$cardBlock->setTitle("Marc2");
//			$cardBlock->setTitleColor("#FFF");
//			$cardBlock->setDescription("Marc Galoyer Developpeur web");
//			$cardBlock->setBackground("/apple-touch-icon.png");
//			$cardBlock->setBackgroundHeight("200px");
//			$cardBlock->setWidth("300px");
//			$cardBlock->setHeight("300px");
//			$blockManager->addBlock($cardBlock, 'card2');
//
//
//			$cardBlock = new CardBlock();
//			$cardBlock->setTitle("Marc3");
//			$cardBlock->setTitleColor("#FFF");
//			$cardBlock->setDescription("Marc Galoyer Developpeur web");
//			$cardBlock->setBackground("/apple-touch-icon.png");
//			$cardBlock->setBackgroundHeight("200px");
//			$cardBlock->setWidth("300px");
//			$cardBlock->setHeight("300px");
//			$blockManager->addBlock($cardBlock, 'card3');
//

			return $this->render(':home:home.html.twig');
		}
	}
