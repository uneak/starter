<?php

	use Symfony\Component\HttpKernel\Kernel;
	use Symfony\Component\Config\Loader\LoaderInterface;

	class AppKernel extends Kernel {
		public function registerBundles() {
			$bundles = array(
				// SYMFONY,
				new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
				new Symfony\Bundle\SecurityBundle\SecurityBundle(),
				new Symfony\Bundle\TwigBundle\TwigBundle(),
				new Symfony\Bundle\MonologBundle\MonologBundle(),
				new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
				new Symfony\Bundle\AsseticBundle\AsseticBundle(),
				new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
				new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
                // FRONTAL,
                new Sp\BowerBundle\SpBowerBundle(),
                new Liip\ImagineBundle\LiipImagineBundle(),
				new Knp\Bundle\MenuBundle\KnpMenuBundle(),
				// DATABASE,
                new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
                new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
                new Vich\UploaderBundle\VichUploaderBundle(),
				// USER,
				new FOS\UserBundle\FOSUserBundle(),
				// UNEAK,
				new Uneak\TemplatesManagerBundle\UneakTemplatesManagerBundle(),
				new Uneak\AssetsManagerBundle\UneakAssetsManagerBundle(),
				new Uneak\FormsManagerBundle\UneakFormsManagerBundle(),
				new Uneak\BlocksManagerBundle\UneakBlocksManagerBundle(),
				new Uneak\RoutesManagerBundle\UneakRoutesManagerBundle(),
                new Uneak\OAuthClientBundle\UneakOAuthClientBundle(),
                new Uneak\OAuthFacebookServiceBundle\UneakOAuthFacebookServiceBundle(),
				// UNEAK SKIN
				new Uneak\MaterialDesignBundle\UneakMaterialDesignBundle(),
				new Uneak\PortoAdminBundle\UneakPortoAdminBundle(),
				// OWN,
				new AppBundle\AppBundle(),
            	new MemberBundle\MemberBundle(),
                new UserBundle\UserBundle()
			);

			if (in_array($this->getEnvironment(), array('dev', 'test'))) {
				$bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
				$bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
				$bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
				$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
				$bundles[] = new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle();
			}

			return $bundles;
		}

		public function registerContainerConfiguration(LoaderInterface $loader) {
			$loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
		}
	}
