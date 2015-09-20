<?php

	namespace Uneak\PortoAdminBundle\Templates\Form;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\FormsManagerBundle\Forms\FormsManager;
    use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;



	class FormTemplate extends BlockTemplate {

        protected $formsManager;

        public function __construct(FormsManager $formsmanager){
            $this->formsManager = $formsmanager;
        }
		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

            $formView = $this->formsManager->createView($block->getForm());
			$options['form'] = $formView;

		}

		public function getRenderTemplate() {
			return 'block_form_template';
		}

	}