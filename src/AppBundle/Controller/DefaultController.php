<?php

	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\MaterialDesignBlocksBundle\Blocks\CardBlock;

	class DefaultController extends Controller {
		/**
		 * @Route("/", name="homepage")
		 */
		public function indexAction() {
			$blockManager = $this->get("uneak.blocksmanager");

			$cardBlock = new CardBlock();
            $cardBlock->setTitle("Marc");
            $cardBlock->setTitleColor("#FFF");
            $cardBlock->setDescription("Marc Galoyer Developpeur web");
            $cardBlock->setBackground("/apple-touch-icon.png");
            $cardBlock->setBackgroundHeight("200px");
            $cardBlock->setWidth("300px");
            $cardBlock->setHeight("300px");
            $blockManager->addBlock($cardBlock, 'card');


			return $this->render(':Home:home.html.twig');
		}
	}
