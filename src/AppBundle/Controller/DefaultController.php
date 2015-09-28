<?php

	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\MaterialDesignBundle\Blocks\CardBlock;
    use Uneak\OAuthClientBundle\OAuth\Authentication;
    use Uneak\OAuthClientBundle\OAuth\ServerFactory;
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

			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$blockBuilder->addBlock("header", "block_main_interface");
			$header = $blockBuilder->getBlock("header");

			$debug = $blockBuilder->debug();

			$header->getHeader()->setBrand("block_content");

			$debug .= $blockBuilder->debug();

			$blockBuilder->getBlock("header");

			$debug .= $blockBuilder->debug();


			$assetsManager = $this->get("uneak.assetsbuildermanager");
			$assetsManager->getAssets();

			$debug .= $blockBuilder->debug();

			$header->getHeader()->getBrand()->setTemplateAlias("MARC");

			$debug .= $blockBuilder->debug();

			$assetsManager->getAssets();

			$debug .= $blockBuilder->debug();

			return $this->render($debug);

//			$this->blockBuilder->addBlock("layout", "block_main_interface");
//			$this->layout = $this->blockBuilder->getBlock("layout");
//
//			$this->layoutHeader = $this->layout->getHeader();
//			$this->layoutContent = $this->layout->getContent();
//			$this->layoutContentBody = $this->layoutContent->getBody();
//			$this->layoutContentHeader = $this->layoutContent->getHeader();
//			$this->breadcrumb = $this->layoutContentHeader->getBreadcrumb();
//
//			$this->layoutLeftSidebar = $this->layout->getLeftSidebar();
//			$this->layoutRightSidebar = $this->layout->getRightSidebar();


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
