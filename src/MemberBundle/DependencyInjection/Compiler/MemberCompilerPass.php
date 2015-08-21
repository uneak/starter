<?php
	namespace MemberBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Reference;

	class MemberCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('uneak.templatesmanager') === false) {
				return;
			}

			$definition = $container->getDefinition('uneak.templatesmanager');

			$templates = array(
				"member_connect_login"                        => "HWIOAuthBundle:Connect:login.html.twig",
				"member_connect_registration_success"         => "HWIOAuthBundle:Connect:registration_success.html.twig",
				"member_connect_registration"                 => "HWIOAuthBundle:Connect:registration.html.twig",
				"member_connect_connect_success"              => "HWIOAuthBundle:Connect:connect_success.html.twig",
				"member_connect_connect_confirm"              => "HWIOAuthBundle:Connect:connect_confirm.html.twig",
				"member_security_login"                       => "MemberBundle:Security:login.html.twig",
				"member_resetting_request"                    => "MemberBundle:Resetting:request.html.twig",
				"member_resetting_password_already_requested" => "MemberBundle:Resetting:passwordAlreadyRequested.html.twig",
				"member_resetting_check_email"                => "MemberBundle:Resetting:checkEmail.html.twig",
				"member_resetting_reset"                      => "MemberBundle:Resetting:reset.html.twig",
				"member_registration_email_txt"               => "MemberBundle:Registration:email.txt.twig",
				"member_registration_register"                => "MemberBundle:Registration:register.html.twig",
				"member_registration_check_email"             => "MemberBundle:Registration:checkEmail.html.twig",
				"member_registration_confirmed"               => "MemberBundle:Registration:confirmed.html.twig",
				"member_profile_show"                         => "MemberBundle:Profile:show.html.twig",
				"member_profile_edit"                         => "MemberBundle:Profile:edit.html.twig",
				"member_changepassword_change_password"       => "MemberBundle:ChangePassword:changePassword.html.twig",
			);

			foreach ($templates as $id => $template) {
				$definition->addMethodCall(
					'set', array($id, $template, false)
				);
			}
		}
	}