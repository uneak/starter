<?php

	namespace Uneak\PortoAdminBundle\Blocks\Todo;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Todos extends Block {
        protected $templateAlias = "block_template_todos";


		protected $fieldset;

		public function __construct($fieldset) {
            parent::__construct();
			$this->fieldset = $fieldset;
		}

		/**
		 * @return mixed
		 */
		public function getFieldset() {
			return $this->fieldset;
		}

		/**
		 * @param mixed $fieldset
		 */
		public function setFieldset($fieldset) {
			$this->fieldset = $fieldset;
		}


		public function addTodo(Todo $todo) {
			$this->addBlock($todo, ":todos");
		}

		public function getTodos() {
			return $this->getBlock(":todos");
		}

	}
