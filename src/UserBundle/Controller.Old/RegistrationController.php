<?php

    /*
	 * This file is part of the FOSUserBundle package.
	 *
	 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

    namespace UserBundle\Controller;

    use FOS\UserBundle\FOSUserEvents;
    use FOS\UserBundle\Event\FormEvent;
    use FOS\UserBundle\Event\GetResponseUserEvent;
    use FOS\UserBundle\Event\FilterUserResponseEvent;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Symfony\Component\Security\Core\Exception\AccessDeniedException;
    use FOS\UserBundle\Model\UserInterface;
    use UserBundle\Form\Type\RegistrationFormType;

    /**
     * Controller managing the registration
     *
     * @author Thibault Duplessis <thibault.duplessis@gmail.com>
     * @author Christophe Coevoet <stof@notk.org>
     */
    class RegistrationController extends Controller {

        public function registerAction(Request $request) {

            $userManager = $this->get('uneak.user_manager');
            $templates = $this->get("uneak.templatesmanager");


            $user = $userManager->createUser();
            $user->setEnabled(true);
            $form = $this->createForm(new RegistrationFormType(), $user);
            $form->handleRequest($request);

            if ($form->isValid()) {


                $emailConfirm = true;
                if ($emailConfirm) {

                    $tokenGenerator = $this->get("fos_user.util.token_generator");
                    $mailer = $this->get("mailer");
                    $session = $this->get("session");


                    $user->setEnabled(false);
                    if (null === $user->getConfirmationToken()) {
                        $user->setConfirmationToken($tokenGenerator->generateToken());
                    }


                    // SEND EMAIL


                    $url = $this->generateUrl('user_registration_confirm', array('token' => $user->getConfirmationToken()), true);
                    $rendered = $this->render($templates->getTemplate("user_registration_email_txt"), array(
                        'user' => $user,
                        'confirmationUrl' =>  $url
                    ));

                    $renderedLines = explode("\n", trim($rendered));
                    $subject = $renderedLines[0];
                    $body = implode("\n", array_slice($renderedLines, 1));

                    $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom('mgaloyer@uneak.fr')
                        ->setTo($user->getEmail())
                        ->setBody($body);

                    $mailer->send($message);

                    $session->set('user_send_confirmation_email/email', $user->getEmail());

                    $url = $this->generateUrl('user_registration_check_email');
                    $response = new RedirectResponse($url);

                } else {

                    $url = $this->generateUrl('user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }


                $userManager->updateUser($user);
                return $response;
            }


            return $this->render($templates->getTemplate("user_registration_register"), array(
                'form' => $form->createView(),
            ));
        }

        /**
         * Tell the user to check his email provider
         */
        public function checkEmailAction() {
            $templates = $this->get("uneak.templatesmanager");

            $email = $this->get('session')->get('user_send_confirmation_email/email');
            $this->get('session')->remove('user_send_confirmation_email/email');
            $user = $this->get('uneak.user_manager')->findUserByEmail($email);

            if (null === $user) {
                throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
            }

            return $this->render($templates->getTemplate("user_registration_check_email"), array(
                'user' => $user,
            ));
        }

        /**
         * Receive the confirmation token from user email provider, login the user
         */
        public function confirmAction(Request $request, $token) {
            $userManager = $this->get('uneak.user_manager');

            $user = $userManager->findUserByConfirmationToken($token);

            if (null === $user) {
                throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
            }

            $user->setConfirmationToken(null);
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $url = $this->generateUrl('user_registration_confirmed');
            $response = new RedirectResponse($url);

            return $response;
        }

        /**
         * Tell the user his account is now confirmed
         */
        public function confirmedAction() {
            $templates = $this->get("uneak.templatesmanager");

            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }

            return $this->render($templates->getTemplate("user_registration_confirmed"), array(
                'user' => $user,
            ));
        }
    }

//    $this->layout->setIcon("user");
//        $this->layout->setTitle("Register");
//
//        $content = new Twig('fos_registration_register', array(
//            'form' => $form->createView(),
//        ));
//
//        $this->layout->setContent($content);
