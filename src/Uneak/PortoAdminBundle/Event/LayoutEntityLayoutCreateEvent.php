<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\PortoAdminBundle\LayoutBuilder\LayoutBuilderInterface;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityLayoutCreateEvent extends LayoutEntityHandlerEvent {

		/**
		 * @var LayoutBuilderInterface
		 */
		protected $layout;
		/**
		 * @var \Uneak\BlocksManagerBundle\Blocks\BlockBuilder
		 */
		private $blockBuilder;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, BlockBuilder $blockBuilder) {
			parent::__construct($route, $request, $crudHandler);
			$this->blockBuilder = $blockBuilder;
		}

		/**
		 * @return LayoutBuilderInterface
		 */
		public function getLayout() {
			return $this->layout;
		}

		/**
		 * @param LayoutBuilderInterface $layout
		 */
		public function setLayout($layout) {
			$this->layout = $layout;
		}

		/**
		 * @return BlockBuilder
		 */
		public function getBlockBuilder() {
			return $this->blockBuilder;
		}


	}
