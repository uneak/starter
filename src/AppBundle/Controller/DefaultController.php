<?php

	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\MaterialDesignBundle\Blocks\CardBlock;

	class DefaultController extends Controller {

		/**
		 * @Route("/test", name="test")
		 */
		public function testAction() {

			return $this->render('UneakPortoAdminBundle:Layout:interface.html.twig');
		}


		/**
		 * @Route("/", name="homepage")
		 */
		public function indexAction() {

//			$templateManager = $this->get("uneak.templatesmanager");
//			ldd($templateManager->all());

			$blockManager = $this->get("uneak.blocksmanager");

			$cardBlock = new CardBlock();
			$cardBlock->setTitle("Marc1");
			$cardBlock->setTitleColor("#FFF");
			$cardBlock->setDescription("Marc Galoyer Developpeur web");
			$cardBlock->setBackground("/apple-touch-icon.png");
			$cardBlock->setBackgroundHeight("200px");
			$cardBlock->setWidth("300px");
			$cardBlock->setHeight("300px");
			$blockManager->addBlock($cardBlock, 'card1');


			$cardBlock = new CardBlock();
			$cardBlock->setTitle("Marc2");
			$cardBlock->setTitleColor("#FFF");
			$cardBlock->setDescription("Marc Galoyer Developpeur web");
			$cardBlock->setBackground("/apple-touch-icon.png");
			$cardBlock->setBackgroundHeight("200px");
			$cardBlock->setWidth("300px");
			$cardBlock->setHeight("300px");
			$blockManager->addBlock($cardBlock, 'card2');


			$cardBlock = new CardBlock();
			$cardBlock->setTitle("Marc3");
			$cardBlock->setTitleColor("#FFF");
			$cardBlock->setDescription("Marc Galoyer Developpeur web");
			$cardBlock->setBackground("/apple-touch-icon.png");
			$cardBlock->setBackgroundHeight("200px");
			$cardBlock->setWidth("300px");
			$cardBlock->setHeight("300px");
			$blockManager->addBlock($cardBlock, 'card3');


			return $this->render(':Home:home.html.twig');
		}
	}
