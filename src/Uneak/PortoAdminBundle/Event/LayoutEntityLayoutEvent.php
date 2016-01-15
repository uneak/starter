<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\PortoAdminBundle\LayoutBuilder\LayoutBuilderInterface;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityLayoutEvent extends LayoutEntityEntityEvent {

		/**
		 * @var LayoutBuilderInterface
		 */
		protected $layout;
		/**
		 * @var \Uneak\BlocksManagerBundle\Blocks\BlockBuilder
		 */
		private $blockBuilder;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, FormInterface $form = null, $entity = null, BlockBuilder $blockBuilder = null, LayoutBuilderInterface $layout = null) {
			parent::__construct($route, $request, $crudHandler, $form, $entity);
			$this->layout = $layout;
			$this->blockBuilder = $blockBuilder;
		}

		/**
		 * @return LayoutBuilderInterface
		 */
		public function getLayout() {
			return $this->layout;
		}

		/**
		 * @return BlockBuilder
		 */
		public function getBlockBuilder() {
			return $this->blockBuilder;
		}


	}
