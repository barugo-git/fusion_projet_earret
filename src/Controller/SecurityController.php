<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LienMagiqueFormType;
use App\Form\MagicType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\CustomLoginLinkHandler;
use App\Services\Mailer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class SecurityController extends AbstractController
{
    private $loginLinkHandler;

    public function __construct(CustomLoginLinkHandler $loginLinkHandler)
    {
        $this->loginLinkHandler = $loginLinkHandler;
    }
//    private $logger;
    //    public function  __construct(LoggerInterface $dbLogger)
    //    {
    //        $this->logger= $dbLogger;
    //    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils ,UserRepository $userRepository): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
       // $error = $authenticationUtilss->getLastAuthenticationError();
        //$username = $utils->getLastUsername();
        // $user->setIsOnline(true);
        $users=$userRepository->findAll();


        $user=$userRepository->findOneBy([
            'email'=>$lastUsername
        ]);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'hasError' => $error,
            'username' => $lastUsername,
            'user'=>$user,
            'users'=>$users]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route(path: '/lien_de_connexion', name: 'magic_link')]
    public function magic(UserRepository $userRepository, MailerInterface $mailer, Request $request): Response
    {


        //$user = new User();
        $form = $this->createForm(MagicType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy([
                'email' => $form->get('email')->getData()
            ]);

            if (!$user) {
                $this->addFlash(
                    'danger',
                    "Identifiants invalides!"
                );

                return $this->redirectToRoute('magic_link');

            } else  {


//                $loginLinkDetails = $this->loginLinkHandler->createLoginLink($user);





                $loginLinkDetails = $this->loginLinkHandler->createLoginLink($user);
               // dd($loginLinkDetails);
//            $email= (new  Email())
//                ->from('apinassirou@gmail.com')
//                ->to($user->getEmail())
//                ->subject('Magic link')
//                ->priority(Email::PRIORITY_HIGH)
//                ->text('votre lien de connexion:' .$loginLinkDetails->getUrl());
//                $mailer->send($email);
                  // if($loginLinkDetails->e)

                $email = (new TemplatedEmail())
                    ->from('moussabaka@openkanz.com')
                    ->to(new Address($user->getEmail()))
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject('Lien de connexion de  : ' . $user->getFullName())
                    ->priority(Email::PRIORITY_HIGH)

                    // path of the Twig template to render
                    ->htmlTemplate('magic/index.html.twig')

                    // pass variables (name => value) to the template
                    ->context([

                        'user' => $user,
                        'lien' => $loginLinkDetails->getUrl()
                    ]);

                $mailer->send($email);


                $this->addFlash(
                    'success',
                    "Un lien vous   a été envoyé dans votre boîte !"
                );

                return $this->redirectToRoute('app_login');
                //dd($loginLinkDetails);

            }




        }
        return $this->render('auth-pass-reset-basic.html.twig', [
            'users' => $userRepository->findAll(),
            'pagetitle' => 'Liste',
            'title' => 'Utilisateurs',
            'lienForm' => $form->createView(),
        ]);


//        $users=$userRepository->findAll();
//        foreach ($users as $user){
//            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);
//            $email= (new  Email())
//                ->from('apinassirou@gmail.com')
//                ->to($user->getEmail())
//                ->subject('Magic link')
//                ->text('Your magic link is:' .$loginLinkDetails->getUrl());
//                $mailer->send($email);
        // dd($loginLinkDetails);
        ///}


    }

    #[Route(path: '/{id}/activationcompte', name: 'actvationcompte', methods: ['GET', 'POST'])]
    public function activation(Request $request, User $user,MailerInterface $mailer,EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse{

//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
        // on utilise le service Mailer créé précédemment

        $user->setActif(true);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash(
            'success',
            "Le compte de "  .$user->getFullName(). " a été activé avec succès!"
        );
        $email = (new TemplatedEmail())
            ->from('moussabaka@openkanz.com')
            ->to(new Address($user->getEmail()))
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Activation de compte : ' . $user->getFullName())
            ->priority(Email::PRIORITY_HIGH)

            // path of the Twig template to render
            ->htmlTemplate('user/activation.html.twig')

            // pass variables (name => value) to the template
            ->context([

                'user' => $user
            ]);

        $mailer->send($email);


        $request->getSession()->getFlashBag()->add('success', "Un mail va vous être envoyé afin que vous puissiez vous connecter à la plateforme de e-Arrêts.");
        return $this->redirectToRoute('app_admin_user');

    }





    #[Route(path: '/{id}/desaactivationcompte', name: 'deactvationcompte', methods: ['GET', 'POST'])]
    public function desactivation(User $user,MailerInterface $mailer,EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse{

//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
        // on utilise le service Mailer créé précédemment

        $user->setActif(false);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash(
            'success',
            "Le compte de " .$user->getFullName().  " a été désactivé avec succès!"
        );


        return $this->redirectToRoute('app_admin_user');

//        }
//
//
//        return $this->render('user/active.html.twig', [
//            'user' => $user,
//            'form' => $form->createView(),
//        ]);


    }


}
