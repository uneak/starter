<?php

	namespace Uneak\PortoAdminBundle\Forms;

	use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\FormEvent;
    use Symfony\Component\Form\FormEvents;
    use Symfony\Component\OptionsResolver\Options;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
    use Uneak\PortoAdminBundle\Forms\DataTransformer\AttributeTransformer;

    class CollectionKeyType extends CollectionType {


        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */

        public function buildForm(FormBuilderInterface $builder, array $options) {

            $builder->addModelTransformer(new AttributeTransformer());
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $e) {
                $input = $e->getData();
                if (null === $input) {
                    return;
                }
                $output = array();
                foreach ($input as $key => $value) {
                    $output[] = array(
                        'key' => $key,
                        'value' => $value
                    );
                }
                $e->setData($output);
            }, 1);
        }

        public function getTheme() {
            return "form_collection_key_theme_template";
        }

		public function getName() {
			return 'uneak_collection_key';
		}

	}
