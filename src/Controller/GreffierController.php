<?php

namespace App\Controller;

use App\Entity\Arrets;
use App\Entity\Audience;
use App\Entity\DeliberationDossiers;
use App\Entity\Dossier;
use App\Entity\MesuresInstructions;
use App\Entity\Mouvement;
use App\Entity\ReponseMesuresInstructions;
use App\Entity\User;
use App\Form\ArretResumeType;
use App\Form\AudienceType;
use App\Form\CalendrierType;
use App\Form\ClotureDossierType;
use App\Form\ConsignationDossierType;
use App\Form\DeliberationDossiersType;
use App\Form\DossierEditType;
use App\Form\DossierFrontType;
use App\Form\DossierRequerantType;
use App\Form\DossierType;
use App\Form\MemoireAmpliatifDossierType;
use App\Form\MemoireEnDefenseDossierType;
use App\Form\MesuresInstructionsType;
use App\Form\MouvementType;
use App\Form\MouvementUpdateType;
use App\Form\OuvertureDossierType;
use App\Form\ReponseMesureType;
use App\Repository\ArrondissementRepository;
use App\Repository\AudienceRepository;
use App\Repository\DeliberationDossiersRepository;
use App\Repository\DossierRepository;
use App\Repository\MesuresInstructionsRepository;
use App\Repository\PartieRepository;
use App\Repository\ReponseMesuresInstructionsRepository;
use App\Repository\RepresentantRepository;
use App\Repository\StatutRepository;
use  App\Repository\ArretsRepository;
use App\Service\CodeGenerator;
use App\Service\FileUploader;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\Mime\from;

#[Route(path: '/greffier/dossiers')]
//#[IsGranted(new Expression('is_granted("ROLE_GREFFIER") or is_granted("ROLE_GREFFIER_EN_CHEF")'))]
class GreffierController extends AbstractController
{
    #[Route(path: '/list-recours', name: 'greffier_recours_list')]
    public function index(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('greffe/liste-recours-by-greffier.html.twig', [
            'dossiers' => $dossierRepository->recoursAutoriseParGreffierChef($this->getUser())
        ]);
    }

    #[Route(path: '/recours-en-d-ouverture', name: 'greffier_en_d_ouverture')]
    public function recoursEnOuverture(DossierRepository $dossierRepository): Response
    {

        $listRecours = $dossierRepository->recourstransfererParGreffierChef($this->getUser());
        return $this->render('greffe/liste-autorisation-greffe-chef.html.twig',
            [
                'dossiers' => $listRecours,
            ]);
    }

//    #[IsGranted(new Expression('is_granted("ROLE_GREFFIER") or is_granted("ROLE_GREFFIER_EN_CHEF") or is_granted("ROLE_BUREAU_ORIENTATION")'))]
//    #[Route(path: '/demandes-en-ligne', name: 'greffier_demande_ligne')]
//    public function demandeEnLigne( #[CurrentUser] User    $user, DossierRepository $dossierRepository): Response
//    {
//        return $this->render('dossier/index.html.twig', [
//            'dossiers' => $dossierRepository->findBy([
//                'etatDossier' => 'NOUVEAU',
////                'createdBy'=>$this->getUser(),
////                'structure'=>$this->getUser()->getStructure()
//            ]),
//        ]);
//    }


    #[Route(path: '/dossier-ouverture/{id}', name: 'greffier_dossier_open')]
    public function ouvertureDossier(Request $request, Dossier $dossier, DossierRepository $dossierRepository): Response

    {

        $form = $this->createForm(OuvertureDossierType::class, $dossier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier('OUVERT');
            $dossier->setDateOuverture(new \DateTime());
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'Le dossier à été ouvert avec sucés');
            return $this->redirectToRoute('greffier_dossier_open_list');
        }

        return $this->render('greffe/greffe_ouverture_dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/liste-dossier-ouvert/', name: 'greffier_dossier_open_list')]
    public function ListeDossierOuvert(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('greffe/liste-autorisation-greffe.html.twig', [
           // listeDossierOuvertEtauRoleParGreffier
           // 'dossiers' => $dossierRepository->listeDossierOuvertParGreffier($this->getUser()),
                    'dossiers' => $dossierRepository->listeDossierOuvertEtauRoleParGreffier($this->getUser()),

        ]);
    }
    #[Route(path: '/conclusion-parquet-pour-avis-parties/', name: 'greffier_dossier_conclusion_parquet')]
    public function dossierConclusionParquet(DossierRepository $dossierRepository): Response
    {

        return $this->render('greffe/avis_parties.html.twig', [
            'dossiers' => $dossierRepository->listeDossierPourAvisParties($this->getUser()),
        ]);
    }

    #[Route(path: '/consignation/{id}', name: 'greffier_dossier_consignation')]
    public function paiementConsigne(Request $request, Dossier $dossier, FileUploader $fileUploader, DossierRepository $dossierRepository): Response
    {
        $form = $this->createForm(ConsignationDossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('document')->getData()) {
                $image = $form->get('document')->getData();
                $fmane = $dossier->getReferenceDossier();
                $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');
                $dossier->setPreuveConsignation($fichier);
            }
            $dossier->setConsignation(true);
//            $piece->setDossier($dossier);
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'Le paiement de la consignation a ete constate');
            return $this->redirectToRoute('greffier_dossier_open_list');
        }
        return $this->render('greffe/paiementConsignation.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/memoire-ampliatif/{id}', name: 'greffier_dossier_memoire_ampliatif')]
    public function memoireAmpliatif(Request $request, Dossier $dossier, FileUploader $fileUploader, DossierRepository $dossierRepository): Response
    {
        $form = $this->createForm(MemoireAmpliatifDossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('document')->getData()) {
                $image = $form->get('document')->getData();
                $fmane = $dossier->getReferenceDossier();
                $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');
                $dossier->setUrlMemoireAmpliatif($fichier);
            }
            $dossier->setMemoireAmpliatif(true);
//            $piece->setDossier($dossier);
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'Le memoire ampliatif a ete produit avec succes ');
            return $this->redirectToRoute('greffier_dossier_open_list');
        }
        return $this->render('greffe/memoireAmpliatif.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/memoire-en-defense/{id}', name: 'greffier_dossier_memoire_en_defense')]
    public function memoireEnDefense(Request $request, Dossier $dossier, FileUploader $fileUploader, DossierRepository $dossierRepository): Response
    {
        $form = $this->createForm(MemoireEnDefenseDossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('document')->getData()) {
                $image = $form->get('document')->getData();
                $fmane = $dossier->getReferenceDossier();
                $fichier = $fileUploader->upload($image, $fmane, 'piecesJointes');
                $dossier->setUrlMemoireEnDefense($fichier);
            }
            $dossier->setMemoireEnDefense(true);
//            $piece->setDossier($dossier);
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'Le paiement de la consignation a ete constate');
            return $this->redirectToRoute('greffier_dossier_open_list');
        }
        return $this->render('greffe/paiementConsignation.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

//    #[Route(path: '/mesures-instructions/dossier/{id}', name: 'greffier_mesures_instructions_dossier_list')]
//    public function listeMesuresInstruction(MesuresInstructionsRepository $mesuresInstructionsRepository, Dossier $dossier): \Symfony\Component\HttpFoundation\Response
//    {
//        //dd($mesuresInstructions);
//        return $this->render('greffe/greffe_liste_instruction_par_dossier.html.twig', [
//            'mesures' => $mesuresInstructionsRepository->findBy(['dossier' => $dossier]),
//            'dossier' => $dossier
//        ]);
//    }

    #[Route(path: '/reposnse-mesures-instruction/instruction/{id}', name: 'greffier_rapporteur_mesures_instructions_reponse')]
    public function reponsemesuresInstruction(Request             $request, DossierRepository $dossierRepository,
                                              MesuresInstructions $mesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository)
    {
        $reponse = new ReponseMesuresInstructions();
        $form = $this->createForm(ReponseMesureType::class, $reponse);
        $form->handleRequest($request);
        $dossier = $mesuresInstructions->getDossier();
        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setMesure($mesuresInstructions);
            $reponseMesuresInstructionsRepository->add($reponse, true);
            return $this->redirectToRoute('greffier_mesures_instructions_dossier_list', ['id' => $mesuresInstructions->getDossier()->getId()]);
        }
        return $this->render('conseiller_rapporteur/reponses_mesures_instructins.html.twig', [
            'mesures' => $mesuresInstructions,
            'form' => $form->createView(),
            'dossier' => $dossier
        ]);
    }


    #[Route(path: '/reposnse-mesures-instruction/instruction/edit/{id}', name: 'greffier_rapporteur_mesures_instructions_reponse_edit')]
    public function reponsemesuresInstructionComplete(Request                    $request, DossierRepository $dossierRepository,
                                                      ReponseMesuresInstructions $reponseMesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository)
    {
//        $reponse = new ReponseMesuresInstructions();
        $form = $this->createForm(ReponseMesureType::class, $reponseMesuresInstructions);
        $form->handleRequest($request);
        $dossier = $reponseMesuresInstructions->getMesure()->getDossier()->getId();
        if ($form->isSubmitted() && $form->isValid()) {

            $reponseMesuresInstructionsRepository->add($reponseMesuresInstructions, true);
            return $this->redirectToRoute('greffier_mesures_instructions_dossier_list', ['id' => $dossier]);
        }
        return $this->render('conseiller_rapporteur/reponses_mesures_instructins.html.twig', [
            'mesures' => $reponseMesuresInstructions->getMesure(),
            'form' => $form->createView(),
            'dossier' => $dossier
        ]);
    }

//    #[Route(path: '/reposnse-mesures-instruction/instruction/show/{id}', name: 'greffier_rapporteur_mesures_instructions_reponse_show')]
//    public function detailsmesuresInstruction(DossierRepository   $dossierRepository,
//                                              MesuresInstructions $mesuresInstructions, ReponseMesuresInstructionsRepository $reponseMesuresInstructionsRepository): \Symfony\Component\HttpFoundation\Response
//    {
//        return $this->render('conseiller_rapporteur/details_mesures_instructins.html.twig', [
//            'mesures' => $mesuresInstructions,
//
//        ]);
//    }

    #[Route(path: '/cloture-dossier/{id}', name: 'greffier_cloture_dossier')]
    public function clotureDossier(Request $request, Dossier $dossier, DossierRepository $dossierRepository)
    {
        $form = $this->createForm(ClotureDossierType::class, $dossier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier('FERME');
            $dossier->setDateCloture(new \DateTime());
            $dossier->setClos(true);
            $dossierRepository->add($dossier, true);
            $this->addFlash('success', 'Le dossier à été cloturé avec succes');
            return $this->redirectToRoute('greffier_dossier_open_list');
        }
        return $this->render('greffe/greffe_fermerture_dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/programmer-une-audience', name: 'greffier_audience_new', methods: ['GET', 'POST'])]
    public function audience(Request $request, AudienceRepository $audienceRepository, MailerInterface $mailer, DossierRepository $dossierRepository): Response
    {
        $audience = new Audience();
        $form = $this->createForm(AudienceType::class, $audience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $audience->setDossier($dossier);
            // $audienceRepository->add($audience, true);
//            $smsMessage = "L'audience du  dossier : " . $dossier->getReferenceDossier() . " a été programmé le : " . $audience->getDateAudience()->format("Y-m-d H:i:s");
//            dd($smsMessage);
            foreach ($form->get('dossiers')->getData() as $dossier) {
                $dossier->setEtatDossier('AUDIENCE');
                $requerant_mail = $dossier->getRequerant()->getEmail();
                $request_telephone = $dossier->getRequerant()->getTelephone();
                $defendeur_mail = $dossier->getDefendeur()->getEmail();
                $defendeur_telephone = $dossier->getDefendeur()->getTelephone();
                $smsMessage = "L'audience du  dossier : " . $dossier->getIntituleObjet() . " a été programmé le : " . $audience->getDateAudience()->format("Y-m-d") . " à " . $audience->getHeureAudience()->format("H:i:s");
                if ($requerant_mail) {
                    $email = (new TemplatedEmail())
                        ->from('xxxxx@fuprobenin.org')
                        ->to(new Address($requerant_mail))
                        // ->priority(Email::PRIORITY_HIGH)
                        ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                        ->priority(Email::PRIORITY_HIGH)

                        // path of the Twig template to render
                        ->htmlTemplate('mailer/partie_audience.html.twig')

                        // pass variables (name => value) to the template
                        ->context([
                            'dossier' => $dossier,
                            'audience' => $audience,
                            'nom' => $dossier->getRequerant()->getNom()

                        ]);

                    $mailer->send($email);
                }

                if ($defendeur_mail) {
                    $email = (new TemplatedEmail())
                        ->from('xxxxx@fuprobenin.org')
                        ->to(new Address($defendeur_mail))
                        // ->priority(Email::PRIORITY_HIGH)
                        ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                        ->priority(Email::PRIORITY_HIGH)

                        // path of the Twig template to render
                        ->htmlTemplate('mailer/partie_audience.html.twig')

                        // pass variables (name => value) to the template
                        ->context([
                            'dossier' => $dossier,
                            'audience' => $audience,
                            'nom' => $dossier->getDefendeur()->getNom()

                        ]);

                    $mailer->send($email);
                }

                /*   if ($request_telephone) {
                       $this->envoiSMS($smsMessage, $request_telephone);

                   }
                   if ($defendeur_telephone) {
                       $this->envoiSMS($smsMessage, $defendeur_telephone);

                   }*/

                foreach ($dossier->getUserDossiers() as $membre) {
                    if ($membre->getUSer()->getEmail()) {
                        $email = (new TemplatedEmail())
                            ->from('xxxxx@fuprobenin.org')
                            ->to(new Address($membre->getUSer()->getEmail()))
                            // ->priority(Email::PRIORITY_HIGH)
                            ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                            ->priority(Email::PRIORITY_HIGH)

                            // path of the Twig template to render
                            ->htmlTemplate('mailer/partie_audience.html.twig')

                            // pass variables (name => value) to the template
                            ->context([
                                'dossier' => $dossier,
                                'audience' => $audience,
                                'nom' => $membre->getUSer()->getNom()

                            ]);

                        $mailer->send($email);
                    }
                }
                $dossier->addAudience($audience);
                $audience->addDossier($dossier);
                $dossierRepository->add($dossier, true);
            }
            $audienceRepository->add($audience, true);
            $this->addFlash('success', 'L\'audience  a été programmé avec succes');
            return $this->redirectToRoute('app_audience_programme', ['id' => $audience->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('audience/new.html.twig', [
            'audience' => $audience,

            'form' => $form,
        ]);
    }

    #[Route(path: '/audience-programme/{id}', name: 'greffier_audience_programme', methods: ['GET', 'POST'])]
    public function audienceProgramme(Audience $audience): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('dossier/audience_programme.html.twig', [
            'audience' => $audience,
//            'user'
        ]);
    }

    #[Route(path: '/audiences/liste', name: 'greffier_audience_liste', methods: ['GET', 'POST'])]
    public function listeAudience(AudienceRepository $audienceRepository): \Symfony\Component\HttpFoundation\Response
    {
        $audiences = $audienceRepository->findBy([], ['id' => 'DESC']);

        return $this->render('audience/index_audience.html.twig', [
            'audiences' => $audiences,

        ]);
    }

    #[Route(path: '/dossier-audience', name: 'greffier_audience_dossier', methods: ['GET', 'POST'])]
    public function dossierPasseEnAudience(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('greffe/dossier-audience-by-greffier.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => "AUDIENCE",
//                'createdBy'=>$this->getUser(),
//                'structure'=>$this->getUser()->getStructure()
            ]),
        ]);
    }

    #[Route(path: '/deliberation-dossier/{id}', name: 'greffier_deliberation_dossier')]
    public function deliberationDossier(Request $request, Dossier $dossier, DossierRepository $dossierRepository, DeliberationDossiersRepository $deliberationDossiersRepository)
    {
        $delibre = new DeliberationDossiers();
        $form = $this->createForm(DeliberationDossiersType::class, $delibre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setEtatDossier('DELIBERE');
            $delibre->setDossier($dossier);
//            $dossier->setDateCloture(new \DateTime());
//            $dossier->setClos(true);
            $dossierRepository->add($dossier);
            $deliberationDossiersRepository->add($delibre, true);
            $this->addFlash('success', 'Le dossier à été deliberer avec succes');
            return $this->redirectToRoute('greffier_deliberation_dossier_list');
        }
        return $this->render('greffe/greffe_deliberer_dossier.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/liste-deliberation-dossier', name: 'greffier_deliberation_dossier_list')]
    public function listeDossierDeliberes(DossierRepository $dossierRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('greffe/dossier-delibere-by-greffier.html.twig', [
            'dossiers' => $dossierRepository->findBy([
                'etatDossier' => "DELIBERE",
//                'createdBy'=>$this->getUser(),
//                'structure'=>$this->getUser()->getStructure()
            ]),
        ]);
    }

    public function envoiSMS($msg, $telephone)
    {
        // 1. Create configuration object and client
        $baseurl = $this->getParameter("sms_gateway.baseurl");
        $apikey = $this->getParameter("sms_gateway.apikey");
        $apikeyPrefix = $this->getParameter("sms_gateway.apikeyprefix");

        $configuration = (new Configuration())
            ->setHost($baseurl)
            ->setApiKeyPrefix('Authorization', $apikeyPrefix)
            ->setApiKey('Authorization', $apikey);

        $client = new \GuzzleHttp\Client();
        $sendSmsApi = new SendSMSApi($client, $configuration);

        // 2. Create message object with destination
        $destination = (new SmsDestination())->setTo($telephone);
        $message = (new SmsTextualMessage())
            // Alphanumeric sender ID length should be between 3 and 11 characters (Example: `CompanyName`).
            // Numeric sender ID length should be between 3 and 14 characters.
            ->setFrom('InfoSMS')
            ->setText($msg)
            ->setDestinations([$destination]);

        // 3. Create message request with all the messages that you want to send
        $request = (new SmsAdvancedTextualRequest())->setMessages([$message]);

        // 4. Send !
        try {
            $smsResponse = $sendSmsApi->sendSmsMessage($request);

            dump($smsResponse);
        } catch (\Throwable $apiException) {
            // HANDLE THE EXCEPTION
            dump($apiException);
        }


    }

    #[Route(path: '{id}/mise-a-jour-statut/', name: 'greffier_mise_ajour')]
    public function ajouterMouvement(Request $request, Dossier $dossier, EntityManagerInterface $em, StatutRepository $statutRepository, MailService $mailService): Response
    {
        $mouvement = new Mouvement();
        $mouvement->setDossier($dossier);

        // dd($statutRepository->findStatutsNonAffectesAuDossier($dossier));

        // Création du formulaire
        $form = $this->createForm(MouvementType::class, $mouvement, [
            'dossier' => $dossier // Passer le dossier pour le filtrage
        ]);

        //  dd($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Définir l'utilisateur actuel comme greffier
            $mouvement->setUser($this->getUser());

            // dd($form->getData());
            $dossier->setStatut($mouvement->getStatut()->getLibelle());

            $em->persist($mouvement);
            $em->persist($dossier);
            $em->flush();

            $this->addFlash('success', 'Le statut du  dossier à été enregistré avec succes');

            $sujet = 'Statut actuel de votre recours';
            $mail = $dossier->getRequerant()->getEmail();
            $context = [
                'requerent' => $dossier->getRequerant()->getPrenoms() . ' ' . $dossier->getRequerant()->getNom(),
                'statut' => $dossier->getStatut(),
                'codeSuivi' => $dossier->getCodeSuivi(),
                'lien' => $this->generateUrl('front_recours_status', [], UrlGeneratorInterface::ABSOLUTE_URL),

            ];

            $mailService->sendEmail($mail, $sujet, 'notificationsstatut.html.twig', $context);

            return $this->redirectToRoute('dossier_historique', ['id' => $dossier->getId()]);
        }

        return $this->render('greffe/miseajourdossier.html.twig', [
            'form' => $form->createView(),
            'dossier' => $dossier
        ]);
    }


    #[Route(path: '/mise-a-jour-historique/{id}', name: 'dossier_historique')]
    public function historique(Dossier $dossier, EntityManagerInterface $em)
    {
        $mouvements = $dossier->getMouvements();

        return $this->render('greffe/historique.html.twig', [
            'dossier' => $dossier,
            'mouvements' => $mouvements,
        ]);
    }


    #[Route(path: '/mise-a-jour/{id}/update', name: 'mouvement_update')]
    public function historiqueedit(Request $request, Mouvement $mouvement, EntityManagerInterface $em)
    {
        //  dd($mouvement);
        $dossier = $mouvement->getDossier();

        $form = $this->createForm(MouvementUpdateType::class, $mouvement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $dossier->setStatut($mouvement->getStatut()->getLibelle());

            $em->persist($mouvement);
            $em->persist($dossier);
            $em->flush();
            $this->addFlash('success', 'Le statut du  dossier à été mis à jour avec succes');

            return $this->redirectToRoute('dossier_historique', ['id' => $dossier->getId()]);


        }

        return $this->render('greffe/miseajourdossierstatut.html.twig', [

            'mouvement' => $mouvement,
            'dossier' => $mouvement->getDossier(),
            'form' => $form
        ]);
    }


    #[Route(path: '/publier-calendrier', name: 'greffier_publie_calendrier', methods: ['GET', 'POST'])]
    public function publierCalendrier(Request $request, FileUploader $fileUploader, DossierRepository $dossierRepository,MailerInterface $mailer): Response
    {
        //  CalendrierType
        $form = $this->createForm(CalendrierType::class, null, [
            'user' => $this->getUser() // Passer le dossier pour le filtrage
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $calendrier = $form->get('calendrier')->getData();
            if ($calendrier) {
                $fichier = $fileUploader->upload($calendrier, null, 'calendrier');

            }

            foreach ($form->get('dossiers')->getData() as $dossier) {
                $dossier->setStatut('Dossier au Rôle');
                $dossier->setCalendrier($fichier);
                $dossierRepository->add($dossier, true);
            }

            $requerant_mail = $dossier->getRequerant()->getEmail();
            $request_telephone = $dossier->getRequerant()->getTelephone();
            $defendeur_mail = $dossier->getDefendeur()->getEmail();
            $defendeur_telephone = $dossier->getDefendeur()->getTelephone();



            $email = (new TemplatedEmail())
                ->from(new Address('juridiction@coursupreme.bj', 'Cour Suprême'))
                ->to(new Address($requerant_mail))
                // ->priority(Email::PRIORITY_HIGH)
                ->subject('Audience Programmée de votre dossier  : ' . $dossier->getReferenceDossier())
                ->priority(Email::PRIORITY_HIGH)

                // path of the Twig template to render
                ->htmlTemplate('mailer/calendrier_mail_front.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'dossier' => $dossier,
                    'calendrier' => $dossier->getCalendrier(),
                    'nom' => $dossier->getRequerant()->getNom()

                ]);

            $mailer->send($email);
            return $this->redirectToRoute('greffier_recours_list');


        }


        return $this->render('greffe/publiercalendrier.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route(path: '/arret/{id}', name: 'greffier_arret_new', methods: ['GET', 'POST'])]
    public function arrets( #[CurrentUser] User    $user,Dossier  $dossier, Request $request, ArretsRepository $arretsRepository,
        FileUploader $fileUploader, MailerInterface $mailer, DossierRepository $dossierRepository): Response
    {
        $arret = new Arrets();
        $form = $this->createForm(ArretResumeType::class, $arret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $arret->setDossier($dossier);
            $file_arret = $form->get('arret_file')->getData();
            $fichier = $fileUploader->upload($file_arret, null);
            $dossier->setStatut('Dossier vidé : Arrêt disponible');
            $arret->setArret($fichier);
            $dossier->setEtatDossier("ARRETS");
            $arretsRepository->add($arret, true);
            // $audienceRepository->add($audience, true);
            //     $smsMessage = "L'audience du  dossier : " . $dossier->getReferenceDossier() . " a été programmé le : " . $audience->getDateAudience()->format("Y-m-d H:i:s");
//            dd($smsMessage);
            $requerant_mail = $dossier->getRequerant()->getEmail();
            $request_telephone = $dossier->getRequerant()->getTelephone();
            $defendeur_mail = $dossier->getDefendeur()->getEmail();
            $defendeur_telephone = $dossier->getDefendeur()->getTelephone();



              $email = (new TemplatedEmail())
                   ->from(new Address('juridiction@coursupreme.bj', 'Cour Suprême'))
                   ->to(new Address($requerant_mail))
                   // ->priority(Email::PRIORITY_HIGH)
                   ->subject('Arrêt du dossier : ' . $dossier->getReferenceDossier())
                   ->priority(Email::PRIORITY_HIGH)

                   // path of the Twig template to render
                   ->htmlTemplate('mailer/auience_mail_front.html.twig')

                   // pass variables (name => value) to the template
                   ->context([
                       'dossier' => $dossier,
                       'arret' => $arret->getArret(),
                       'nom' => $dossier->getRequerant()->getNom()

                   ]);

               $mailer->send($email);


           /* if ($defendeuail) {
                $email = (new TemplatedEmail())
                    ->from('xxxxx@fuprobenin.org')
                    ->to(new Address($defendeur_mail))
                    // ->priority(Email::PRIORITY_HIGH)
                    ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                    ->priority(Email::PRIORITY_HIGH)

                    // path of the Twig template to render
                    ->htmlTemplate('mailer/partie_audience.html.twig')

                    // pass variables (name => value) to the template
                    ->context([
                        'dossier' => $dossier,
                        'audience' => $audience,
                        'nom' => $dossier->getDefendeur()->getNom()

                    ]);

                $mailer->send($email);
            }

            foreach ($dossier->getUserDossiers() as $membre) {
                if ($membre->getUSer()->getEmail()) {
                    $email = (new TemplatedEmail())
                        ->from('xxxxx@fuprobenin.org')
                        ->to(new Address($membre->getUSer()->getEmail()))
                        // ->priority(Email::PRIORITY_HIGH)
                        ->subject('Programmation de l\'audience du dossier : ' . $dossier->getReferenceDossier())
                        ->priority(Email::PRIORITY_HIGH)

                        // path of the Twig template to render
                        ->htmlTemplate('mailer/partie_audience.html.twig')

                        // pass variables (name => value) to the template
                        ->context([
                            'dossier' => $dossier,
                            'audience' => $audience,
                            'nom' => $membre->getUSer()->getNom()

                        ]);

                    $mailer->send($email);
              }
            }


            /*         if ($request_telephone) {
                         $this->envoiSMS($smsMessage, $request_telephone);

                     }
                     if ($defendeur_telephone) {
                         $this->envoiSMS($smsMessage, $defendeur_telephone);

                     }*/
            $this->addFlash('success', 'L\'audience du dossier : ' . $dossier->getReferenceDossier() . ' a été programmé avec succes');
            return $this->redirectToRoute('admin_arret_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('greffe/publicationarret.html.twig', [
            'arret' => $arret,
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }


}
