<?php

	namespace Uneak\PortoAdminBundle\Templates;

	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate as BlocksManagerBlockTemplate;
    use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    class BlockTemplate extends BlocksManagerBlockTemplate {

        public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            $options['uniqid'] = $block->getUniqid();
            $options['classes'] = $block->getClasses();
        }

	}
