<?php

	namespace Uneak\PortoAdminBundle\Templates\Content;

	use Symfony\Component\DependencyInjection\ContainerInterface;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;



	class TwigTemplate extends BlockTemplate {

        protected $container;

        public function __construct(ContainerInterface $container){
            $this->container = $container;
        }
		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

//			$twig = new \Twig_Environment(new \Twig_Loader_Array(array()));
//			$template = $twig->createTemplate($form->get('message')->getData());
//			$smsMessage = $template->render(array_merge($crmValue, array(
//				'url' => $shorten["url"],
//			)));

			$template = ($templatesManager->getTemplate($block->getTemplate())) ? $templatesManager->getTemplate($block->getTemplate()) : $block->getTemplate();
			$options['content'] = $this->container->get('templating')->render($template, $block->getParameters());

		}

		public function getRenderTemplate() {
			return '{{ content | raw }}';
		}

	}