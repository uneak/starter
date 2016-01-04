<?php

	namespace Uneak\PortoAdminBundle\Blocks\Datatable;

	use Uneak\AssetsManagerBundle\Assets\AssetBuilder;
	use Uneak\BlocksManagerBundle\Blocks\Component;
	use Uneak\AssetsManagerBundle\Assets\Css\AssetExternalCss;
	use Uneak\AssetsManagerBundle\Assets\Js\AssetExternalJs;
	use Uneak\AssetsManagerBundle\Assets\Js\AssetInternalJs;
	use Uneak\PortoAdminBundle\Blocks\Block;

	class Datatable extends Block {

		protected $templateAlias = "block_template_datatable";

		protected $columns = array();
		protected $iDisplayLength = 10;
		protected $stateSave = false;
		protected $processing = true;
		protected $serverSide = true;
		protected $searchInput = null;
		protected $query = null;
		protected $ajax;
		protected $scriptTemplate;

		public function __construct() {
			parent::__construct();
		}

		/**
		 * @return null
		 */
		public function getSearchInput() {
			return $this->searchInput;
		}

		/**
		 * @param null $searchInput
		 */
		public function setSearchInput($searchInput) {
			$this->searchInput = $searchInput;
		}


        /**
         * @return mixed
         */
        public function getQuery() {
            return $this->query;
        }

        /**
         * @param mixed $ajax
         */
        public function setQuery($query) {
            $this->query = $query;
            return $this;
        }

		/**
		 * @return mixed
		 */
		public function getAjax() {
			return $this->ajax;
		}

		/**
		 * @param mixed $ajax
		 */
		public function setAjax($ajax) {
			$this->ajax = $ajax;
			return $this;
		}

		/**
		 * @return int
		 */
		public function getIDisplayLength() {
			return $this->iDisplayLength;
		}

		/**
		 * @param int $iDisplayLength
		 */
		public function setIDisplayLength($iDisplayLength) {
			$this->iDisplayLength = $iDisplayLength;

			return $this;
		}

		/**
		 * @return boolean
		 */
		public function isProcessing() {
			return $this->processing;
		}

		/**
		 * @param boolean $processing
		 */
		public function setProcessing($processing) {
			$this->processing = $processing;

			return $this;
		}

		/**
		 * @return boolean
		 */
		public function isServerSide() {
			return $this->serverSide;
		}

		/**
		 * @param boolean $serverSide
		 */
		public function setServerSide($serverSide) {
			$this->serverSide = $serverSide;

			return $this;
		}

		/**
		 * @return boolean
		 */
		public function isStateSave() {
			return $this->stateSave;
		}

		/**
		 * @param boolean $stateSave
		 */
		public function setStateSave($stateSave) {
			$this->stateSave = $stateSave;

			return $this;
		}


		public function addColumn($column) {
			array_push($this->columns, $column);

			return $this;
		}

		public function removeColumn($column) {
			$key = array_search($column, $this->columns);
			if ($key !== false) {
				array_splice($this->columns, $key, 1);
			}

			return $this;
		}

		public function getColumns() {
			return $this->columns;
		}

		public function setColumns($columns) {
			$this->columns = $columns;

			return $this;
		}


	}
