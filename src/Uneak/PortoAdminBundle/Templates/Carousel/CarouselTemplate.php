<?php

	namespace Uneak\PortoAdminBundle\Templates\Carousel;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class CarouselTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_carousel_js')
			;

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

			$options['options'] = $this->_getJsArray($block->getOptions());
			$options['items'] = $block->getBlock(":items");

		}

        protected function _getJsArray(array $array = null) {
            $returnArray = array();
            foreach ($array as $key => $value) {
                if (!is_null($value)) {
                    $returnArray[$key] = $value;
                }
            }
            $json = json_encode($returnArray);
            $json = preg_replace_callback("/(?:\"|')##(.*?)##(?:\"|')/", function ($matches) {
                return stripslashes($matches[1]);
            }, $json);
            return $json;
        }

		public function getRenderTemplate() {
			return 'block_carousel_template';
		}

	}