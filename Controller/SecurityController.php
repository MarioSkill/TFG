<?php

namespace BenchmarkBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class SecurityController extends Controller {
    public function loginAction(Request $request) {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
 
        return $this->render('BenchmarkBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
        /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {           

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/recover_pass", name="recover_pass")
     */
    public function recoverPasswordAction(Request $request)
    {
        $data = array();

        $form = $this->createFormBuilder($data)
            ->add('email', 'email')
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $user = $this->getDoctrine()
                    ->getRepository('YouMustKnowItNewsBundle:User')
                    ->findOneByEmail($data['email']);

                if (isset($user)) {
                    $this->createNewPassword($user);                
                    return $this->redirect($this->generateUrl('homepage'));                    
                } else {
                    $this->get('session')->getFlashbag()->add(
                        'error_message',
                        'The user with such email doesn\'t exist.'
                    );
                }          
            }
        }

        return $this->render('YouMustKnowItNewsBundle:Default:recoverPass.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail(User $user)
    {           
        $message = \Swift_Message::newInstance()
            ->setSubject('YouMustKnowIt! Password restoration.')
            ->setFrom('php.gr2@gmail.com')
            ->setTo($user->getEmail())
            ->setBody('Your new password: ' . $user->getPassword());

        $this->get('mailer')->send($message);
    }

    private function generatePassword($length = 7)
    {
        $num = range(0, 9);
        $alf = range('a', 'z');
        $_alf = range('A', 'Z');
        $symbols = array_merge($num, $alf, $_alf);
        shuffle($symbols);
        $code_array = array_slice($symbols, 0, $length);
        $code = implode("", $code_array);
        return $code;
    }

    private function encodePassword(User $user)
    {
        $factory  = $this->get('security.encoder_factory');
        $encoder  = $factory->getEncoder($user);
        $password = $encoder->encodePassword(
            $user->getPassword(), 
            $user->getSalt()
        );

        return $password;
    }

    private function createNewPassword(User $user)
    {
        $password = $this->generatePassword();
        $user->setPassword($password);
        $this->sendEmail($user);
        $encodedPassword = $this->encodePassword($user);
        $user->setPassword($encodedPassword);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        $this->get('session')->getFlashbag()->add(
             'success_message',
             'On your email the new password was sent.'
        );
    }
}

