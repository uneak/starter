<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;


    class LayoutController extends Controller {

        protected $blockBuilder;
        protected $layout;


        public function setContainer(ContainerInterface $container = null) {
            parent::setContainer($container);
            $this->blockBuilder = $this->get("uneak.blocksmanager.builder");
            $this->blockBuilder->addBlock("layout", "block_main_interface");
            $this->layout = $this->blockBuilder->getBlock("layout");

//            $this->layout->setLayoutStyle(MainInterface::LAYOUT_STYLE_DEFAULT);
//            $this->layout->setBackgroundColor(MainInterface::COLOR_DARK);
//            $this->layout->setHeaderColor(MainInterface::COLOR_DARK);
//            $this->layout->setSidebarLeftSize(MainInterface::SIDEBAR_LEFT_SIZE_MD);
        }



	}
