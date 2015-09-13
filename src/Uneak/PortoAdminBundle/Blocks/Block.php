<?php

	namespace Uneak\PortoAdminBundle\Blocks;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;

    class Block extends BlockModel {

        protected $classes = array();
        protected $uniqid;

		public function __construct() {
            $this->uniqid = uniqid('comp_');
		}

        public function getUniqid() {
            return $this->uniqid;
        }

        public function addClass($class) {
            $this->classes[$class] = $class;
        }

        public function removeClass($class) {
            unset($this->classes[$class]);
        }

        public function getClasses() {
            return " ".join(" ", $this->classes);
        }

        public function setClasses($classes) {
            $this->classes = array();
            if (is_string($classes)) {
                $classes = explode(" ", $classes);
            }

            foreach ($classes as $class) {
                $this->addClass($class);
            }

            return $this;
        }
	}
