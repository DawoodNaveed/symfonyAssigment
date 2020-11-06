<?php

namespace App\Controller;
use App\Form\Login;
use App\Form\SignUpFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    public function logout(SessionInterface $session)
    {
        $session->invalidate();
        return $this->redirectToRoute('app_login');

    }

    public function checkingUserRole(Request $request,UserPasswordEncoderInterface $encoder,SessionInterface $session)
    {
        $roles=($this->getUser()->getRoles());
        $loginUser=($this->getUser());
        $loginUserId=$loginUser->getId();
        $session->set('loginUser', $loginUserId);

        if($roles==["ROLE_USER"]) {
            return $this->redirectToRoute('userView');
        } else {
            return $this->redirectToRoute('admin');
        }

    }

    public function signUp(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $form=$this->createForm(SignUpFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()) {
            $user=$form->getData();

            $user->setPassword($encoder->encodePassword(
               $user,
               $user->getPassword()
            ));

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success','Registered Successfully');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('security/signUp.html.twig',[
            'signUpForm' => $form->createView()
    ]);

    }
    public function homePage()
    {
        return $this->redirectToRoute('app_login');
    }
}