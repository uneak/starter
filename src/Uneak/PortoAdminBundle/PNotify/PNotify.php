<?php

	namespace Uneak\PortoAdminBundle\PNotify;


	use Symfony\Component\OptionsResolver\OptionsResolver;

	class PNotify {


		protected $options;
		protected $resolver;
		protected $resolved = false;

		public function __construct(array $options) {
			$this->options = $options;
			$this->resolver = new OptionsResolver();
			$this->configureOptions($this->resolver);
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'title'                  => false,
				'title_escape'           => false,
				'text'                   => false,
				'text_escape'            => false,
//				'styling'                => "brighttheme",
				'addclass'               => "",
				'cornerclass'            => "",
//				'auto_display'           => true,
				'width'                  => "300px",
//				'min_height'             => "16px",
				'type'                   => "notice",
				'icon'                   => true,
//				'animation'              => "fade",
//				'animate_speed'          => "slow",
//				'position_animate_speed' => 500,
//				'opacity'                => 1.0,
				'shadow'                 => true,
//				'hide'                   => true,
//				'delay'                  => 8000,
//				'mouse_reset'            => true,
//				'remove'                 => true,
//				'insert_brs'             => true,
				'stack_preset'           => "stack-bar-bottom",
				'stack'                  => array(
					'dir1' => "down",
					'dir2' => "left",
					'push' => "bottom",
					'spacing1' => 25,
					'spacing2' => 25,
					'context' => "##$('body')##",
				),
			));

			$resolver->setAllowedTypes('title', array('string', 'boolean'));
			$resolver->setAllowedTypes('title_escape', array('string', 'boolean'));
			$resolver->setAllowedTypes('text', array('string', 'boolean'));
			$resolver->setAllowedTypes('text_escape', array('string', 'boolean'));
//			$resolver->setAllowedTypes('styling', array('string'));
			$resolver->setAllowedTypes('addclass', array('string'));
			$resolver->setAllowedTypes('cornerclass', array('string'));
//			$resolver->setAllowedTypes('auto_display', array('boolean'));
			$resolver->setAllowedTypes('width', array('string'));
//			$resolver->setAllowedTypes('min_height', array('string'));
			$resolver->setAllowedValues('type', array("notice", "info", "success", "error"));
			$resolver->setAllowedTypes('icon', array('string', 'boolean'));
//			$resolver->setAllowedValues('animation', array("fade", "none"));
//			$resolver->setAllowedTypes('animate_speed', array('string', 'number'));
//			$resolver->setAllowedTypes('position_animate_speed', array('int'));
//			$resolver->setAllowedTypes('opacity', array('float', 'int'));
			$resolver->setAllowedTypes('shadow', array('boolean'));
//			$resolver->setAllowedTypes('hide', array('boolean'));
//			$resolver->setAllowedTypes('delay', array('int'));
//			$resolver->setAllowedTypes('mouse_reset', array('boolean'));
//			$resolver->setAllowedTypes('remove', array('boolean'));
//			$resolver->setAllowedTypes('insert_brs', array('boolean'));
			$resolver->setAllowedTypes('stack_preset', array('string'));

			$resolver->setAllowedValues('stack_preset', array(
				"stack-topright",
				"stack-topleft",
				"stack-bottomleft",
				"stack-bottomright",
				"stack-bar-top",
				"stack-bar-bottom"
			));

			$resolver->setNormalizer('addclass', function ($options, $value) {
				return $value." ".$options['stack_preset'];
			});



			$resolver->setNormalizer('width', function ($options, $value) {

				if (is_null($options['stack_preset'])) {
					return $value;
				}

				$width = null;
				switch ($options['stack_preset']) {
					case "stack-bar-top":
						$width = "100%";
						break;
					case "stack-bar-bottom":
						$width = "70%";
						break;
				}
				return $width;

			});



			$resolver->setNormalizer('stack', function ($options, $value) {

				$stack = null;
				switch ($options['stack_preset']) {
					case "stack-topright":
						$stack = "stack_topright";
						break;
					case "stack-topleft":
						$stack = "stack_topleft";
						break;
					case "stack-bottomleft":
						$stack = "stack_bottomleft";
						break;
					case "stack-bottomright":
						$stack = "stack_bottomright";
						break;
					case "stack-bar-top":
						$stack = "stack_bar_top";
						break;
					case "stack-bar-bottom":
						$stack = "stack_bar_bottom";
						break;
				}

				return "##".$stack."##";

			});

		}


		public function setOption($key, $value) {
			$this->options[$key] = $value;
			$this->resolved = false;
		}

		public function getOption($key) {
			if (!$this->resolved) {
				$this->resolve();
			}
			return $this->options[$key];
		}

		public function getOptions()
		{
			if (!$this->resolved) {
				$this->resolve();
			}
			return $this->options;
		}

		public function setOptions(array $options)
		{
			$this->options = $options;
			$this->resolved = false;
		}

		protected function resolve() {
			$this->options = $this->resolver->resolve($this->options);
			$this->resolved = true;
		}


	}
