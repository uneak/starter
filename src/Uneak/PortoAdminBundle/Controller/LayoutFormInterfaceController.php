<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Uneak\PortoAdminBundle\Blocks\Layout\FormInterface;


    class LayoutFormInterfaceController extends Controller implements LayoutControllerInterface {

        protected $blockBuilder;
        protected $layout;
        protected $layoutContent;



        public function setContainer(ContainerInterface $container = null) {
            parent::setContainer($container);
            $this->blockBuilder = $this->get("uneak.blocksmanager.builder");
            $this->blockBuilder->addBlock("layout", new FormInterface());
            $this->layout = $this->blockBuilder->getBlock("layout");
            $this->layoutContent = $this->layout->getContent();
        }



	}
