<?php

	namespace Uneak\PortoAdminBundle\Templates\PNotify;

	use Symfony\Component\HttpFoundation\Session\Session;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class PNotifyTemplate extends BlockTemplate {


		/**
		 * @var \Symfony\Component\HttpFoundation\Session\Session
		 */
		private $session;

		public function __construct(Session $session) {
			$this->session = $session;
		}

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_pnotify_css')
				->add('porto_admin_pnotify_js')
				->add('pnotify_script', 'internaljs', array(
					'template'   => 'pnotify_script_template',
					'parameters' => array('flashbag' => $this->session->getFlashBag())
				))
			;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
//			$options['title'] = $block->getTitle();
//			$options['description'] = $block->getDescription();
//			$options['photo'] = $block->getPhoto();
//			$options['link'] = $block->getLink();

		}

		public function getRenderTemplate() {
			return null;
		}

	}