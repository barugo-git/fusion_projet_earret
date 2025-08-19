<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\PasswordUpdateProfile;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\PasswordUpdateUserType;
use App\Form\RegistrationFormType;
use App\Form\UpdateUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use App\Model\ProfilePhotoUpdate;
use App\Form\ProfilePhotoUpdateType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route(path: '/users')]
class UserController extends AbstractController
{
    #[Route(path: '/', name: 'app_admin_user', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('user/index-user1.html.twig', [
            'users' => $userRepository->findAll(),
            'pagetitle' => 'Liste',
            'title' => 'Utilisateurs',

        ]);
    }

    #[Route(path: '/nouveau', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function new(Request $request, MailerInterface $mailer, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );


            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('moussabaka@openkanz.com')
                ->to(new Address($user->getEmail()))
                // ->priority(Email::PRIORITY_HIGH)
                ->subject('Création de compte utilisateur de : ' . $user->getFullName())
                ->priority(Email::PRIORITY_HIGH)

                // path of the Twig template to render
                ->htmlTemplate('mailer/index.html.twig')

                // pass variables (name => value) to the template
                ->context([

                    'user' => $user,
                    'password' => $form->get('password')->getData()
                ]);

            $mailer->send($email);


//            // 1. Create configuration object and client
//            $baseurl = $this->getParameter("sms_gateway.baseurl");
//            $apikey = $this->getParameter("sms_gateway.apikey");
//            $apikeyPrefix = $this->getParameter("sms_gateway.apikeyprefix");
//
//            $configuration = (new Configuration())
//                ->setHost($baseurl)
//                ->setApiKeyPrefix('Authorization', $apikeyPrefix)
//                ->setApiKey('Authorization', $apikey);
//
//            $client = new \GuzzleHttp\Client();
//            $sendSmsApi = new SendSMSApi($client, $configuration);
//
//            // 2. Create message object with destination
//            $destination = (new SmsDestination())->setTo('229'.$user->getTelephone());
//            $message = (new SmsTextualMessage())
//                // Alphanumeric sender ID length should be between 3 and 11 characters (Example: `CompanyName`).
//                // Numeric sender ID length should be between 3 and 14 characters.
//                ->setFrom('InfoSMS')
//                ->setText('Salut'.''.$user->getFullName() .' '. ' votre compte a été crée')
//                ->setDestinations([$destination]);
//
//            // 3. Create message request with all the messages that you want to send
//            $request = (new SmsAdvancedTextualRequest())->setMessages([$message]);
//
//            // 4. Send !
//            try {
//                $smsResponse = $sendSmsApi->sendSmsMessage($request);
//
//               // dump($smsResponse);
//            } catch (\Throwable $apiException) {
//                // HANDLE THE EXCEPTION
//              // dump($apiException);
//            }

            // return new Response("Success (?)");


//
//// Your Account SID and Auth Token from twilio.com/console
//            $account_sid = 'ACXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
//            $auth_token = 'your_auth_token';
//// In production, these should be environment variables. E.g.:
//// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
//
//// A Twilio number you own with SMS capabilities
//            $twilio_number = "+15017122661";
//
//            $client = new Client($account_sid, $auth_token);
//            $client->messages->create(
//            // Where to send a text message (your cell phone?)
//                '+22997719794',
//                array(
//                    'from' => $twilio_number,
//                    'body' => 'I sent this message in under 10 minutes!'
//                )
//            );


            $this->addFlash(
                'success',
                "Votre enregistrement a été effectué avec succès!"
            );

            // dd($form->get('email')->getData());


            return $this->redirectToRoute('app_admin_user');
        }

        return $this->render('user/new-user1.html.twig', [

            'pagetitle' => 'Liste',
            'title' => 'Utilisateurs',
            'registrationForm' => $form->createView(),
        ]);

    }

    #[Route('/account/photo-update', name: 'account_photo_update')]
    #[IsGranted('ROLE_USER')]
    public function updateProfilePhoto(
        Request $request,
        EntityManagerInterface $entityManager,
        ParameterBagInterface $params,
        SluggerInterface $slugger
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $photoUpdate = new ProfilePhotoUpdate();
        
        $form = $this->createForm(ProfilePhotoUpdateType::class, $photoUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $photoUpdate->getNewPhoto();
            
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                try {
                    // Supprimer l'ancienne photo si elle existe
                    if ($user->getPhoto()) {
                        $oldPhotoPath = $params->get('profile_photos_directory').'/'.$user->getPhoto();
                        if (file_exists($oldPhotoPath)) {
                            unlink($oldPhotoPath);
                        }
                    }

                    // Déplacer le nouveau fichier
                    $photoFile->move(
                        $params->get('profile_photos_directory'),
                        $newFilename
                    );

                    // Mettre à jour l'utilisateur
                    $user->setPhoto($newFilename);
                    $entityManager->flush();

                    $this->addFlash('success', 'Photo de profil mise à jour avec succès !');
                    return $this->redirectToRoute('app_index');
                } catch (FileException $e) {
                    $this->addFlash('error', "Erreur lors de l'upload : ".$e->getMessage());
                }
            }
        }

        return $this->render('user/update_photo.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateUserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy([
                'id' => $user->getId()
            ]);
            // encode the plain password
//            $user->setPassword(
//                $userPasswordHasher->hashPassword(
//                    $user,
//                    $form->get('password')->getData()
//                )
//            );

            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('app_admin_user');


        }
        return $this->render('user/edit-user.html.twig', [
            'user' => $user,
            'pagetitle' => 'Liste',
            'title' => 'Utilisateurs',
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Permet de reinitaliser le mot de passe
     *
     * @return Response
     */
    #[Route(path: '/{id}/account/password-update', name: 'reset_password_by_admin')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function updatePassword(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $userRepository->findOneBy([
            'id' => $user->getId()
        ]);

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $encoder->hashPassword(
                    $user,
                    $form->get('newPassword')->getData()
                )
            );

            $newPassword = $passwordUpdate->getNewPassword();
            $hash = $encoder->hashPassword($user, $newPassword);

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "le mot de passe" . '' . $user->getFullName() . " a bien été reinitialisé !"
            );

            return $this->redirectToRoute('app_admin_user');

        }


        return $this->render('user/password.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }


    /**
     * Permet de modifier le mot de passe
     *
     *
     * @return Response
     */
    #[Route(path: '/account/password-update/by-user', name: 'account_password_user')]
    #[IsGranted('ROLE_USER')]
    public function updatePasswordByUser(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager)
    {
        $passwordUpdate = new PasswordUpdateProfile();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateUserType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 1. Vérifier que le oldPassword du formulaire soit le même que le password de l'user
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                // Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->hashPassword($user, $newPassword);

                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );

                return $this->redirectToRoute('app_login');
            }
        }


        return $this->render('user/pages-profile-settings.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     *
     *
     * @return Response
     */
    #[Route(path: '/account/profile-update', name: 'account_profile_update_by_user')]
    #[IsGranted('ROLE_USER')]
    public function profile(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();

        // dd($user);

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les données du profil ont été enregistrées avec succès !"
            );
            // dd($user);
            return $this->redirectToRoute('app_login');

        }

        return $this->render('user/update-profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route(path: '/u/mise-a-jour-password', name: 'account_profile_update_password')]
    #[IsGranted('ROLE_USER')]
    public function udpatePassword(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdateProfile();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateUserType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 1. Vérifier que le oldPassword du formulaire soit le même que le password de l'user
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                // Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->hashPassword($user, $newPassword);

                $user->setPassword($hash);
                $user->setPasswordChangeRequired(false);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );

                return $this->redirectToRoute('app_login');
            }
        }


        return $this->render('security/maj_pwd.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

}
