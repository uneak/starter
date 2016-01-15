<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Helper\MenuHelper;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityGridDatatableEvent extends LayoutEntityHandlerEvent {

		/**
		 * @var array
		 */
		protected $datatable;
		/**
		 * @var \Uneak\RoutesManagerBundle\Helper\GridHelper
		 */
		private $gridHelper;
		/**
		 * @var \Uneak\RoutesManagerBundle\Helper\MenuHelper
		 */
		private $menuHelper;
		/**
		 * @var \Uneak\BlocksManagerBundle\Blocks\BlockBuilder
		 */
		private $blockBuilder;
		/**
		 * @var array
		 */
		private $params;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, GridHelper $gridHelper, MenuHelper $menuHelper, BlockBuilder $blockBuilder, $params) {
			parent::__construct($route, $request, $crudHandler);
			$this->gridHelper = $gridHelper;
			$this->menuHelper = $menuHelper;
			$this->blockBuilder = $blockBuilder;
			$this->params = $params;
		}

		/**
		 * @return GridHelper
		 */
		public function getGridHelper() {
			return $this->gridHelper;
		}

		/**
		 * @return MenuHelper
		 */
		public function getMenuHelper() {
			return $this->menuHelper;
		}

		/**
		 * @return BlockBuilder
		 */
		public function getBlockBuilder() {
			return $this->blockBuilder;
		}

		/**
		 * @return array
		 */
		public function getParams() {
			return $this->params;
		}



		/**
		 * @return array
		 */
		public function getDatatable() {
			return $this->datatable;
		}

		/**
		 * @param array $datatable
		 */
		public function setDatatable($datatable) {
			$this->datatable = $datatable;
		}

	}
