<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 21/08/15
	 * Time: 16:41
	 */

	namespace Uneak\MaterialDesignBlocksBundle\Blocks;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class CardBlock extends BlockModel {

        protected $attributes = array();
        protected $title;
        protected $titleColor;
        protected $background;
        protected $backgroundHeight;
        protected $description;
        protected $actions;
        protected $menu;
        protected $width;
        protected $height;

        /**
         * @return mixed
         */
        public function getAttributes()
        {
            return $this->attributes;
        }

        /**
         * @param mixed $attributes
         */
        public function setAttributes($attributes)
        {
            $this->attributes = $attributes;
        }

        /**
         * @param $key
         * @param $value
         */
        public function addAttribute($key, $value)
        {
            if (!isset($this->attributes[$key])) {
                $this->attributes[$key] = array();
            }
            $this->attributes[$key][] = $value;
        }

        public function removeAttribute($key, $value)
        {
            if (isset($this->attributes[$key]) && false !== $i = array_search($value, $this->attributes[$key])) {
                array_splice($this->attributes[$key], $i, 1);
                if (count($this->attributes[$key]) == 0) {
                    unset($this->attributes[$key]);
                }
            }
        }


        /**
         * @return mixed
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description)
        {
            $this->description = $description;
        }

        /**
         * @return mixed
         */
        public function getTitle()
        {
            return $this->title;
        }

        /**
         * @param mixed $title
         */
        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * @return mixed
         */
        public function getTitleColor()
        {
            return $this->titleColor;
        }

        /**
         * @param mixed $titleColor
         */
        public function setTitleColor($titleColor)
        {
            $this->titleColor = $titleColor;
        }

        /**
         * @return mixed
         */
        public function getBackground()
        {
            return $this->background;
        }

        /**
         * @param mixed $background
         */
        public function setBackground($background)
        {
            $this->background = $background;
        }

        /**
         * @return mixed
         */
        public function getBackgroundHeight()
        {
            return $this->backgroundHeight;
        }

        /**
         * @param mixed $backgroundHeight
         */
        public function setBackgroundHeight($backgroundHeight)
        {
            $this->backgroundHeight = $backgroundHeight;
        }

        /**
         * @return mixed
         */
        public function getActions()
        {
            return $this->actions;
        }

        /**
         * @param mixed $actions
         */
        public function setActions($actions)
        {
            $this->actions = $actions;
        }

        /**
         * @return mixed
         */
        public function getMenu()
        {
            return $this->menu;
        }

        /**
         * @param mixed $menu
         */
        public function setMenu($menu)
        {
            $this->menu = $menu;
        }

        /**
         * @return mixed
         */
        public function getWidth()
        {
            return $this->width;
        }

        /**
         * @param mixed $width
         */
        public function setWidth($width)
        {
            $this->width = $width;
        }

        /**
         * @return mixed
         */
        public function getHeight()
        {
            return $this->height;
        }

        /**
         * @param mixed $height
         */
        public function setHeight($height)
        {
            $this->height = $height;
        }



		public function getBlockName() {
			return "block_card_model";
		}

	}