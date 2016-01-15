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
				new Cocur\Slugify\Bridge\Symfony\CocurSlugifyBundle(),
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
                new Uneak\OAuthGoogleServiceBundle\UneakOAuthGoogleServiceBundle(),
                new Uneak\OAuthTwitterServiceBundle\UneakOAuthTwitterServiceBundle(),
                new Uneak\ProspectBundle\UneakProspectBundle(),
                new Uneak\FieldBundle\UneakFieldBundle(),
                new Uneak\FieldDataBundle\UneakFieldDataBundle(),
                new Uneak\FieldTypeBundle\UneakFieldTypeBundle(),
                new Uneak\FieldGroupBundle\UneakFieldGroupBundle(),
                new Uneak\ConstraintBundle\UneakConstraintBundle(),
                new Uneak\FieldSearchBundle\UneakFieldSearchBundle(),
				new Uneak\ImportBundle\UneakImportBundle(),
				new Uneak\ExecBundle\UneakExecBundle(),
				// OAUTH
				new JMS\SerializerBundle\JMSSerializerBundle(),
				new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
				new FOS\RestBundle\FOSRestBundle(),
				new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
				// UNEAK SKIN
				new Uneak\MaterialDesignBundle\UneakMaterialDesignBundle(),
				new Uneak\PortoAdminBundle\UneakPortoAdminBundle(),
				// OWN,
				new AppBundle\AppBundle(),
                new OAuthServerBundle\OAuthServerBundle(),
                new UserBundle\UserBundle(),
                new ClientBundle\ClientBundle(),
                new CampaignBundle\CampaignBundle(),
                new FieldGroupBundle\FieldGroupBundle(),
                new ProspectBundle\ProspectBundle(),
                new FieldBundle\FieldBundle(),
                new ConstraintBundle\ConstraintBundle(),
            	new ImportBundle\ImportBundle(),
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
